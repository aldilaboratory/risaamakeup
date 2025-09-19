<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config as MidConfig;
use Midtrans\Snap as MidSnap;
use Midtrans\Transaction as MidTransaction;

class BookingController extends Controller
{
    public function create(Category $category, Package $package)
    {
        return view('booking.create', compact('category','package'));
    }

    public function store(Request $request, Category $category, Package $package)
    {
        // Calculate minimum date (2 days from today)
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

        // Set fixed values for simplified booking
        $qty        = 1;
        $unitPrice  = (int) $package->price;
        $subtotal   = $unitPrice;
        $dpPercent  = 100;
        $payNow     = $unitPrice;

        // ⬅️ SIMPAN ke variabel!
        $booking = Booking::create([
            'package_id'   => $package->id,
            'category_id'  => $category->id,
            'name'         => $data['name'],
            'phone'        => $data['phone'],
            'city'         => $data['city'] ?? null,
            'location'     => $data['location'],
            'event_date'   => $data['event_date'],
            'event_time'   => $data['event_time'],
            'qty'          => $qty,
            'dp_percent'   => $dpPercent,
            'subtotal'     => $subtotal,
            'pay_now'      => $payNow,
            'notes'        => $data['notes'] ?? null,
            'status'       => 'pending',
        ]);

        // Redirect ke halaman yang memunculkan Snap
        return redirect()->route('booking.pay.page', $booking);
    }

    private function midConfig(): void
    {
        MidConfig::$serverKey    = config('midtrans.server_key');
        MidConfig::$isProduction = (bool) config('midtrans.is_production');
        MidConfig::$isSanitized  = true;
        MidConfig::$is3ds        = true;
    }

    // Buat snap token
    private function createSnapToken(Booking $booking, Package $package): string
    {
        $this->midConfig();

        // Gunakan order_id yang sudah ada atau buat yang baru
        $orderId = $booking->midtrans_order_id ?: 'BOOK-'.now()->format('YmdHis').'-'.Str::upper(Str::random(6));

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
        ];

        $snapToken = MidSnap::getSnapToken($params);
        
        // Simpan order_id dan snap_token ke database
        $booking->update([
            'midtrans_order_id' => $orderId,
            'midtrans_snap_token' => $snapToken,
        ]);

        return $snapToken;
    }

    // Halaman pemicu Snap
    public function payPage(Booking $booking)
    {
        // Cek status pembayaran terlebih dahulu
        if ($booking->payment_status === 'paid') {
            // Jika sudah paid, redirect ke thank you page
            return redirect()->route('booking.thank-you', $booking);
        }

        // Jika ada midtrans_order_id, cek status terbaru dari Midtrans
        if ($booking->midtrans_order_id) {
            $this->midConfig();
            try {
                $status = \Midtrans\Transaction::status($booking->midtrans_order_id);
                $trx = $status->transaction_status ?? 'pending';
                $fraud = $status->fraud_status ?? null;

                $map = [
                    'capture'    => ($fraud === 'challenge') ? 'pending' : 'paid',
                    'settlement' => 'paid',
                    'pending'    => 'pending',
                    'deny'       => 'failed',
                    'expire'     => 'expired',
                    'cancel'     => 'cancel',
                    'failure'    => 'failed',
                ];

                $newStatus = $map[$trx] ?? 'pending';
                
                // Update status di database
                $booking->update([
                    'payment_status' => $newStatus,
                    'midtrans_payload' => json_encode($status),
                ]);

                // Jika status sudah paid, redirect ke thank you page
                if ($newStatus === 'paid') {
                    return redirect()->route('booking.thank-you', $booking);
                }

                // Jika masih pending/unpaid dan ada snap_token, gunakan yang existing
                if (in_array($newStatus, ['pending', 'unpaid']) && $booking->midtrans_snap_token) {
                    return view('booking.snap', [
                        'booking'   => $booking,
                        'snapToken' => $booking->midtrans_snap_token,
                        'clientKey' => config('midtrans.client_key'),
                    ]);
                }

                // Jika expired atau failed, buat order baru
                if (in_array($newStatus, ['expired', 'cancel', 'failed'])) {
                    // Reset order_id dan snap_token untuk membuat yang baru
                    $booking->update([
                        'midtrans_order_id' => null,
                        'midtrans_snap_token' => null,
                    ]);
                }
            } catch (\Exception $e) {
                // Jika error saat cek status, gunakan snap token yang ada jika tersedia
                if ($booking->midtrans_snap_token && in_array($booking->payment_status, ['pending', 'unpaid'])) {
                    return view('booking.snap', [
                        'booking'   => $booking,
                        'snapToken' => $booking->midtrans_snap_token,
                        'clientKey' => config('midtrans.client_key'),
                    ]);
                }
            }
        }

        // Jika sudah ada snap_token dan status masih pending/unpaid, gunakan yang existing
        if ($booking->midtrans_snap_token && in_array($booking->payment_status, ['pending', 'unpaid'])) {
            return view('booking.snap', [
                'booking'   => $booking,
                'snapToken' => $booking->midtrans_snap_token,
                'clientKey' => config('midtrans.client_key'),
            ]);
        }

        // Generate snap token baru jika belum ada atau expired/failed
        $package   = $booking->package;
        $snapToken = $this->createSnapToken($booking, $package);

        return view('booking.snap', [
            'booking'   => $booking,
            'snapToken' => $snapToken,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    // Callback tanpa webhook (cek status manual)
    public function checkStatus(Request $req) {
        $this->midConfig();
        $orderId = $req->string('order_id');
        $booking = Booking::where('midtrans_order_id', $orderId)->firstOrFail();

        $status = MidTransaction::status($orderId);
        $trx    = $status->transaction_status ?? 'pending';
        $fraud  = $status->fraud_status ?? null;

        $map = [
            'capture'    => ($fraud === 'challenge') ? 'pending' : 'paid',
            'settlement' => 'paid',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'expire'     => 'expired',
            'cancel'     => 'cancel',
            'failure'    => 'failed',
        ];
        $booking->update([
            'payment_status'  => $map[$trx] ?? 'pending',
            'midtrans_payload'=> json_encode($status),
        ]);

        return response()->json(['ok' => true, 'payment_status' => $booking->payment_status]);
    }

    // Webhook (kalau punya URL publik)
    public function notificationHandler()
    {
        $this->midConfig();
        $notif = new \Midtrans\Notification();

        $orderId = $notif->order_id;
        $status  = $notif->transaction_status;
        $type    = $notif->payment_type;
        $fraud   = $notif->fraud_status ?? null;

        $booking = Booking::where('midtrans_order_id', $orderId)->first();
        if (!$booking) return response()->json(['message'=>'booking not found'], 404);

        $map = [
            'capture'    => ($fraud === 'challenge') ? 'pending' : 'paid',
            'settlement' => 'paid',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'expire'     => 'expired',
            'cancel'     => 'cancel',
            'failure'    => 'failed',
        ];
        $va  = $notif->va_numbers[0]->va_number ?? null;
        $pdf = $notif->pdf_url ?? null;

        $booking->update([
            'payment_status'          => $map[$status] ?? 'pending',
            'midtrans_transaction_id' => $notif->transaction_id ?? null,
            'midtrans_payment_type'   => $type,
            'midtrans_va_number'      => $va,
            'midtrans_pdf_url'        => $pdf,
            'midtrans_payload'        => json_encode($notif),
        ]);

        return response()->json(['message'=>'ok']);
    }

    // Thank you page after successful payment
    public function thankYou(Booking $booking)
    {
        return view('booking.thank-you', compact('booking'));
    }
}
