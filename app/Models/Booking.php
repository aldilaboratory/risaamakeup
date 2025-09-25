<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id','package_id','category_id','name','phone','city','location',
        'event_date','event_time','qty','dp_percent','subtotal',
        'pay_now','notes','status',
        'payment_status','midtrans_order_id','midtrans_snap_token',
        'midtrans_transaction_id','midtrans_payment_type','midtrans_va_number',
        'midtrans_pdf_url','midtrans_payload','expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
