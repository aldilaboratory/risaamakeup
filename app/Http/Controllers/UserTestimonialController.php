<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTestimonialController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        abort_unless((int)$booking->user_id === (int)auth()->id(), 403);
        abort_unless($booking->payment_status === 'paid', 403); // opsional: hanya boleh jika lunas

        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $t = \App\Models\Testimonial::updateOrCreate(
            ['booking_id'=>$booking->id,'user_id'=>auth()->id()],
            ['rating'=>$data['rating'],'comment'=>$data['comment']??null]
        );

        if ($request->expectsJson()) return response()->json(['success'=>true,'testimonial'=>$t]);
        return redirect()->route('user.bookings')->with('success','Testimoni disimpan.');
    }

    public function update(Request $request, Booking $booking)
    {
        abort_unless((int)$booking->user_id === (int)auth()->id(), 403);

        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $t = \App\Models\Testimonial::where('booking_id',$booking->id)
            ->where('user_id',auth()->id())->firstOrFail();

        $t->update($data);

        if ($request->expectsJson()) return response()->json(['success'=>true,'testimonial'=>$t]);
        return redirect()->route('user.bookings')->with('success','Testimoni diperbarui.');
    }
}
