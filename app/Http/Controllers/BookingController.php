<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Booking;
use App\Services\FonnteWhatsApp;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config as MidConfig;
use Midtrans\Snap as MidSnap;
use Midtrans\Transaction as MidTransaction;

class BookingController extends Controller
{
    public function create(Category $category, Package $package)
    {
        return view('booking.create', compact('category', 'package'));
    }

    public function store(Request $request, Category $category, Package $package)
    {
        // Minimal 2 hari dari hari ini
        $minDate = now()->addDays(2)->format('Y-m-d');

        $data = $request->validate([
            'city'        => 'nullable|string|max:100',
            'event_date'  => 'required|date|after_or_equal:' . $minDate,
            'event_time'  => 'required',
            'location'    => 'required|string|max:200',
            'name'        => 'required|string|max:120',
            'phone'       => 'required|string|max:30',
            'notes'       => 'nullable|string|max:1000',
            'agree'       => 'accepted',
        ], [
            'agree.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
            'event_date.after_or_equal' => 'Tanggal acara minimal 2 hari dari hari ini.',
        ]);

        // Sederhana: 1 item, bayar full
        $unitPrice = (int) $package->price;
        $subtotal  = $unitPrice;

        $booking = Booking::create([
            'user_id'      => auth()->id(),
            'package_id'   => $package->id,
            'category_id'  => $category->id,
            'name'         => $data['name'],
            'phone'        => $data['phone'],
            'city'         => $data['city'] ?? null,
            'location'     => $data['location'],
            'event_date'   => $data['event_date'],
            'event_time'   => $data['event_time'],
            'subtotal'     => $subtotal,
            'notes'        => $data['notes'] ?? null,
            'status'       => 'pending',
            // payment_status default-nya biarkan null / 'pending' sesuai skema tabelmu
        ]);

        return redirect()->route('booking.pay.page', $booking);
    }

    private function midConfig(): void
    {
        MidConfig::$serverKey    = config('midtrans.server_key');
        MidConfig::$isProduction = (bool) config('midtrans.is_production');
        MidConfig::$isSanitized  = true;
        MidConfig::$is3ds        = true;
    }

    /** Buat Snap Token + simpan order_id, snap_token, expires_at */
    private function createSnapToken(Booking $booking, Package $package): string
    {
        $this->midConfig();

        $orderId = $booking->midtrans_order_id ?: 'BOOK-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $package->price,
            ],
            'item_details' => [[
                'id'       => (string) $package->id,
                'price'    => (int) $package->price,
                'quantity' => 1,
                'name'     => Str::limit($package->title, 50),
            ]],
            'customer_details' => [
                'first_name' => $booking->name,
                'phone'      => $booking->phone,
                'billing_address'  => ['address' => $booking->location, 'city' => $booking->city],
                'shipping_address' => ['address' => $booking->location, 'city' => $booking->city],
            ],
            'callbacks' => [
                'finish' => route('booking.thank-you', ['booking' => $booking->id]),
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit'       => 'hour',
                'duration'   => 1,
            ],
        ];

        $snapToken = MidSnap::getSnapToken($params);

        $booking->update([
            'midtrans_order_id'   => $orderId,
            'midtrans_snap_token' => $snapToken,
            'expires_at'          => now()->addHour(),
        ]);

        return $snapToken;
    }

    /** Map status Midtrans ke status internal */
    private function mapMidtransStatus(string $trx, ?string $fraud = null): string
    {
        $map = [
            'capture'    => ($fraud === 'challenge') ? 'pending' : 'paid',
            'settlement' => 'paid',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'expire'     => 'expired',
            'cancel'     => 'cancel',
            'failure'    => 'failed',
        ];
        return $map[$trx] ?? 'pending';
    }

    /** Update status + kirim WA kalau transisi jadi paid */
    private function updatePaymentStatusAndNotify(Booking $booking, string $newStatus, $payload = null): void
    {
        $oldStatus = $booking->payment_status;

        $booking->update([
            'payment_status'   => $newStatus,
            'midtrans_payload' => $payload ? (is_string($payload) ? $payload : json_encode($payload)) : $booking->midtrans_payload,
        ]);

        // Hanya kirim ketika barusan jadi paid
        if ($oldStatus !== 'paid' && $newStatus === 'paid') {
            $this->sendPaidWhatsapp($booking);
        }

        \Log::info('[WA] updatePaymentStatusAndNotify', ['old' => $oldStatus, 'new' => $newStatus, 'booking_id' => $booking->id]);
\Log::info('[WA] sendPaidWhatsapp CALLED', ['booking_id' => $booking->id, 'phone' => $booking->phone]);

    }

    /** Kirim WA via Fonnte untuk pembayaran berhasil */
    private function sendPaidWhatsapp(Booking $booking): void
    {
        // Hindari dobel kirim kalau sudah pernah (opsional bila kamu pakai kolom timestamp)
        if (!empty($booking->whatsapp_paid_sent_at)) {
            return;
        }

        $orderId = $booking->midtrans_order_id ?? ('BOOK-' . $booking->id);
        $name    = $booking->name;
        $pkg     = $booking->package->title;
        $dateStr = $booking->event_date->format('d M Y');
        $time    = $booking->event_time;
        $amount  = number_format((int) $booking->subtotal, 0, ',', '.');

        $thankYouUrl = route('booking.thank-you', ['booking' => $booking->id]);

        $message = <<<TXT
        Halo {$name}, pembayaran Anda *BERHASIL* ✅

        Rincian Pesanan:
        • Order ID: {$orderId}
        • Paket: {$pkg}
        • Tanggal Acara: {$dateStr} {$time}
        • Total: Rp {$amount}

        Terima kasih telah mempercayai Risaa Makeup 🙏
        Lihat detail pesanan:
        {$thankYouUrl}

        Jika ada pertanyaan, cukup balas pesan ini ya.
        TXT;

        try {
            $ok = FonnteWhatsApp::send($booking->phone, $message);
            if ($ok) {
                $booking->forceFill(['whatsapp_paid_sent_at' => now()])->save();
            }
        } catch (\Throwable $e) {
            \Log::warning('Fonnte send failed: ' . $e->getMessage());
        }
    }

    /** Halaman yang memicu Snap */
    public function payPage(Booking $booking)
    {
        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.thank-you', $booking);
        }

        if ($booking->midtrans_order_id) {
            $this->midConfig();
            try {
                $status = \Midtrans\Transaction::status($booking->midtrans_order_id);
                $trx    = $status->transaction_status ?? 'pending';
                $fraud  = $status->fraud_status ?? null;

                $newStatus = $this->mapMidtransStatus($trx, $fraud);
                $this->updatePaymentStatusAndNotify($booking, $newStatus, $status);

                if ($newStatus === 'paid') {
                    return redirect()->route('booking.thank-you', $booking);
                }

                if (in_array($newStatus, ['pending', 'unpaid']) && $booking->midtrans_snap_token) {
                    return view('booking.snap', [
                        'booking'   => $booking,
                        'snapToken' => $booking->midtrans_snap_token,
                        'clientKey' => config('midtrans.client_key'),
                    ]);
                }

                if (in_array($newStatus, ['expired', 'cancel', 'failed'])) {
                    $booking->update([
                        'midtrans_order_id'   => null,
                        'midtrans_snap_token' => null,
                    ]);
                }
            } catch (\Exception $e) {
                if ($booking->midtrans_snap_token && in_array($booking->payment_status, ['pending', 'unpaid'])) {
                    return view('booking.snap', [
                        'booking'   => $booking,
                        'snapToken' => $booking->midtrans_snap_token,
                        'clientKey' => config('midtrans.client_key'),
                    ]);
                }
            }
        }

        if ($booking->midtrans_snap_token && in_array($booking->payment_status, ['pending', 'unpaid'])) {
            return view('booking.snap', [
                'booking'   => $booking,
                'snapToken' => $booking->midtrans_snap_token,
                'clientKey' => config('midtrans.client_key'),
            ]);
        }

        $package   = $booking->package;
        $snapToken = $this->createSnapToken($booking, $package);

        return view('booking.snap', [
            'booking'   => $booking,
            'snapToken' => $snapToken,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    /** Polling tanpa webhook (manual check) */
    public function checkStatus(Request $req)
    {
        $this->midConfig();

        $orderId = $req->string('order_id');
        $booking = Booking::where('midtrans_order_id', $orderId)->firstOrFail();

        $status = MidTransaction::status($orderId);
        $trx    = $status->transaction_status ?? 'pending';
        $fraud  = $status->fraud_status ?? null;

        $newStatus = $this->mapMidtransStatus($trx, $fraud);
        $this->updatePaymentStatusAndNotify($booking, $newStatus, $status);

        return response()->json(['ok' => true, 'payment_status' => $booking->payment_status]);
    }

    /** Webhook Midtrans */
    public function notificationHandler()
    {
        $this->midConfig();

        $notif = new \Midtrans\Notification();

        $orderId = $notif->order_id;
        $trx     = $notif->transaction_status;
        $type    = $notif->payment_type;
        $fraud   = $notif->fraud_status ?? null;

        $booking = Booking::where('midtrans_order_id', $orderId)->first();
        if (!$booking) return response()->json(['message' => 'booking not found'], 404);

        $newStatus = $this->mapMidtransStatus($trx, $fraud);

        // simpan info tambahan VA/PDF
        $va  = $notif->va_numbers[0]->va_number ?? null;
        $pdf = $notif->pdf_url ?? null;

        $booking->fill([
            'midtrans_transaction_id' => $notif->transaction_id ?? null,
            'midtrans_payment_type'   => $type,
            'midtrans_va_number'      => $va,
            'midtrans_pdf_url'        => $pdf,
        ])->save();

        // update status + kirim WA bila perlu
        $this->updatePaymentStatusAndNotify($booking, $newStatus, $notif);

        return response()->json(['message' => 'ok']);
    }

    /** Thank you page */
    public function thankYou(Booking $booking)
    {
        return view('booking.thank-you', compact('booking'));
    }

    /** Halaman pesanan user */
    public function userBookings()
    {
        $bookings = Booking::with(['package', 'category', 'testimonial'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('booking.user-bookings', compact('bookings'));
    }

    /** Regenerate Snap Token */
    public function regenerateSnapToken(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!in_array($booking->payment_status, ['pending', 'unpaid'])) {
            return response()->json(['error' => 'Booking sudah dibayar atau tidak valid'], 400);
        }

        if ($booking->expires_at && now()->greaterThan($booking->expires_at)) {
            return response()->json(['error' => 'Waktu pembayaran sudah habis. Silakan buat pesanan baru.'], 400);
        }

        try {
            $package   = $booking->package;
            $snapToken = $this->createSnapToken($booking, $package);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal membuat token pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /** Invoice PDF */
    public function invoice(Booking $booking)
    {
        // Otorisasi sederhana
        if (method_exists($booking, 'user_id') && $booking->user_id) {
            if (Auth::id() !== (int) $booking->user_id && Auth::user()?->role !== 'admin') {
                abort(403);
            }
        } else {
            if (!Auth::check()) abort(403);
        }

        $booking->load(['package', 'category']);

        $pdf = Pdf::loadView('booking.invoice', ['booking' => $booking])->setPaper('a4');
        $fileName = 'Invoice-RisaaMakeup-#' . $booking->id . '.pdf';

        return $pdf->stream($fileName);
    }
}
