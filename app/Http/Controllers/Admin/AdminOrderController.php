<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['package', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['package', 'category']);
        return view('admin.orders.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        $booking->update([
            'status' => 'confirmed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil disetujui!',
            'status' => 'confirmed'
        ]);
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        $booking->update([
            'status' => 'canceled',
            'notes' => $request->rejection_reason ? 
                ($booking->notes ? $booking->notes . "\n\nAlasan penolakan: " . $request->rejection_reason : "Alasan penolakan: " . $request->rejection_reason) : 
                $booking->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil ditolak!',
            'status' => 'canceled'
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,canceled,done'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diupdate!',
            'status' => $request->status
        ]);
    }
}