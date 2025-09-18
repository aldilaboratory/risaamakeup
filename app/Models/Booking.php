<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'package_id','category_id','name','phone','city','location',
        'event_date','event_time','qty','dp_percent','subtotal',
        'pay_now','notes','status'
    ];

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
