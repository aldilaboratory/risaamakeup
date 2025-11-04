<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Booking::with(['package','category'])->latest();

        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        $bookings = $q->paginate(15);

        return view('admin.orders.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['package','category']);
        return view('admin.orders.show', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        // map otomatis ke enum yang didukung DB
        $newStatus = $this->supportsNewEnum() ? 'approved' : 'confirmed';
        $booking->update(['status' => $newStatus]);

        if ($request->expectsJson()) {
            // kirimkan status “new naming” ke UI agar konsisten
            $uiStatus = $this->supportsNewEnum() ? $newStatus : ($this->toNew()[$newStatus] ?? $newStatus);
            return response()->json([
                'success' => true,
                'status'  => $uiStatus,
                'message' => 'Booking disetujui.',
            ]);
        }

        return back()->with('success', 'Booking disetujui.');
    }

    public function reject(Request $request, Booking $booking)
    {
        if ($request->filled('rejection_reason')) {
            // pastikan kolom ada; jika tidak ada, silakan hapus baris ini
            $booking->rejection_reason = $request->string('rejection_reason');
        }

        $newStatus = $this->supportsNewEnum() ? 'rejected' : 'canceled';
        $booking->status = $newStatus;
        $booking->save();

        if ($request->expectsJson()) {
            $uiStatus = $this->supportsNewEnum() ? $newStatus : ($this->toNew()[$newStatus] ?? $newStatus);
            return response()->json([
                'success' => true,
                'status'  => $uiStatus,
                'message' => 'Booking ditolak.',
            ]);
        }

        return back()->with('success', 'Booking ditolak.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $incoming = $request->string('status');
        $supportsNew = $this->supportsNewEnum();

        $allowedNew = ['pending','approved','rejected','completed','cancelled'];
        $allowedOld = ['pending','confirmed','canceled','done'];

        // peta dua arah
        $toNew = $this->toNew(); // confirmed->approved, canceled->rejected, done->completed
        $toOld = $this->toOld(); // approved->confirmed, rejected->canceled, completed->done, cancelled->canceled

        // Normalisasi ke enum DB yang aktif
        $normalized = $incoming;
        if ($supportsNew) {
            if (isset($toNew[$incoming])) $normalized = $toNew[$incoming];
            if (!in_array($normalized, $allowedNew, true)) {
                return $this->jsonOrBack($request, false, 'Status tidak valid untuk enum baru', 422);
            }
        } else {
            if (isset($toOld[$incoming])) $normalized = $toOld[$incoming];
            if (!in_array($normalized, $allowedOld, true)) {
                return $this->jsonOrBack($request, false, 'Status tidak valid untuk enum lama', 422);
            }
        }

        try {
            $booking->update(['status' => $normalized]);

            // untuk UI, kembalikan “new naming”
            $uiStatus = $supportsNew ? $normalized : ($toNew[$normalized] ?? $normalized);

            return $this->jsonOrBack($request, true, 'Status berhasil diupdate.', 200, [
                'status' => $uiStatus,
            ]);
        } catch (\Throwable $e) {
            return $this->jsonOrBack($request, false, 'Gagal update status: '.$e->getMessage(), 500);
        }
    }

    /** Deteksi enum versi baru */
    protected function supportsNewEnum(): bool
    {
        return Booking::whereIn('status', ['approved','rejected','completed','cancelled'])->exists();
    }

    /** Map old -> new */
    protected function toNew(): array
    {
        return [
            'confirmed' => 'approved',
            'canceled'  => 'rejected',
            'done'      => 'completed',
        ];
    }

    /** Map new -> old */
    protected function toOld(): array
    {
        return [
            'approved'  => 'confirmed',
            'rejected'  => 'canceled',
            'completed' => 'done',
            'cancelled' => 'canceled',
        ];
    }

    /** Helper balikan JSON/redirect */
    protected function jsonOrBack(Request $request, bool $success, string $message, int $code = 200, array $extra = [])
    {
        if ($request->expectsJson()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message,
            ], $extra), $code);
        }
        return $success
            ? back()->with('success', $message)
            : back()->with('error', $message);
    }
}
