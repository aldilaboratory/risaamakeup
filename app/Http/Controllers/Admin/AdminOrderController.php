<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Booking::with(['package','category'])
            ->latest();

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
        // Gunakan enum yang sesuai di DB Anda. Misal sudah: pending/approved/rejected/completed/cancelled
        $booking->update(['status' => 'approved']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => 'approved',
                'message' => 'Booking disetujui.',
            ]);
        }

        return back()->with('success', 'Booking disetujui.');
    }

    public function reject(Request $request, Booking $booking)
    {
        // Simpan alasan jika ada (pastikan kolomnya ada, jika tidak hapus baris ini)
        if ($request->filled('rejection_reason')) {
            $booking->rejection_reason = $request->string('rejection_reason');
        }

        // Sesuaikan dengan enum status di DB Anda: 'rejected' (baru) atau 'canceled' (lama)
        $newStatus = $this->supportsNewEnum() ? 'rejected' : 'canceled';

        $booking->status = $newStatus;
        $booking->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => $newStatus,
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

        $status = $request->string('status');

        // Validasi status sederhana; bisa Anda perketat sesuai enum Anda
        $allowedNew = ['pending','approved','rejected','completed','cancelled'];
        $allowedOld = ['pending','confirmed','canceled','done'];

        if (! in_array($status, array_merge($allowedNew, $allowedOld), true)) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Status tidak valid'], 422)
                : back()->with('error', 'Status tidak valid');
        }

        $booking->update(['status' => $status]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => $status,
                'message' => 'Status berhasil diupdate.',
            ]);
        }

        return back()->with('success', 'Status berhasil diupdate.');
    }

    /**
     * Deteksi enum versi baru (approved/rejected/completed/cancelled) atau lama (confirmed/canceled/done).
     * Sederhana: jika ada data dengan 'approved', anggap enum baru.
     */
    protected function supportsNewEnum(): bool
    {
        return Booking::where('status', 'approved')->exists()
            || Booking::where('status', 'rejected')->exists()
            || Booking::where('status', 'completed')->exists()
            || Booking::where('status', 'cancelled')->exists();
    }
}
