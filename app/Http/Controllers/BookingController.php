<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Category $category, Package $package)
    {
        // Tampilkan form booking khusus paket yg dipilih
        return view('booking.create', compact('category','package'));
    }

    public function store(Request $request, Category $category, Package $package)
    {
        $data = $request->validate([
            'city'        => 'nullable|string|max:100',
            'qty'         => 'required|integer|min:1',
            'event_date'  => 'required|date|after_or_equal:today',
            'event_time'  => 'required',
            'location'    => 'required|string|max:200',
            'name'        => 'required|string|max:120',
            'phone'       => 'required|string|max:30',
            'notes'       => 'nullable|string|max:1000',
            'dp_percent'  => 'nullable|integer|in:0,50,100', // contoh opsi
            'agree'       => 'accepted',
        ], [
            'agree.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
        ]);

        $qty        = (int) $data['qty'];
        $unitPrice  = (int) $package->price;
        $subtotal   = $unitPrice * $qty;
        $dpPercent  = (int) ($data['dp_percent'] ?? 100);
        $payNow     = (int) round($subtotal * $dpPercent / 100);

        Booking::create([
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

        return redirect()
            ->route('packages.public.show', ['category' => $category, 'package' => $package])
            ->with('success', 'Request booking terkirim. Kami akan menghubungi Anda.');
    }
}
