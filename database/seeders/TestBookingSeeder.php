<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Package;
use App\Models\Booking;

class TestBookingSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama
        $user = User::first();
        
        // Ambil kategori pertama
        $category = Category::first();
        
        // Ambil package pertama dari kategori tersebut
        $package = Package::where('category_id', $category->id)->first();
        
        // Update booking yang sudah ada tanpa user_id
        Booking::whereNull('user_id')->update(['user_id' => $user->id]);
        
        // Buat booking test baru
        Booking::firstOrCreate([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'category_id' => $category->id,
            'name' => 'Test User',
            'phone' => '081234567890',
            'event_date' => now()->addDays(30)->format('Y-m-d'),
        ], [
            'event_time' => '10:00',
            'location' => 'Jakarta Convention Center',
            'notes' => 'Test booking untuk tracking',
            'status' => 'confirmed',
            'qty' => 1,
            'dp_percent' => 100,
            'subtotal' => $package->price,
            'pay_now' => $package->price,
            'payment_status' => 'paid',
        ]);
    }
}