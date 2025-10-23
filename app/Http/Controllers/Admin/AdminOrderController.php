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
        $booking->update(['status' => 'confirmed']);

        if (request()->wantsJson()) {
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
        $booking->update([
            'status' => 'canceled',
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status'  => 'canceled',
                'message' => 'Booking ditolak.',
            ]);
        }

        return back()->with('success', 'Booking ditolak.');
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