<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil booking masuk terbaru (10 terakhir)
        $recentBookings = Booking::with(['package'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Statistik booking
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $paidBookings = Booking::where('payment_status', 'paid')->count();
        $todayBookings = Booking::whereDate('created_at', today())->count();

        // Debug untuk memastikan data ada
        \Log::info('Dashboard Data:', [
            'recentBookings_count' => $recentBookings->count(),
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'paidBookings' => $paidBookings,
            'todayBookings' => $todayBookings
        ]);

        return view('admin.dashboard', compact(
            'recentBookings', 
            'totalBookings', 
            'pendingBookings', 
            'paidBookings', 
            'todayBookings'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
