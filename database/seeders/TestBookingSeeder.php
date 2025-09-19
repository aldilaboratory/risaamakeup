<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Package;

class TestBookingSeeder extends Seeder
{
    public function run()
    {
        // Get first package
        $package = Package::first();
        
        if (!$package) {
            echo "No packages found. Please create packages first.\n";
            return;
        }

        // Create test bookings
        Booking::create([
            'name' => 'Test Customer 1',
            'phone' => '081234567890',
            'package_id' => $package->id,
            'event_date' => now()->addDays(30),
            'event_time' => '10:00:00',
            'location' => 'Jakarta',
            'city' => 'Jakarta',
            'subtotal' => $package->price,
            'pay_now' => $package->price,
            'status' => 'pending',
            'notes' => 'Test booking for approve function'
        ]);

        Booking::create([
            'name' => 'Test Customer 2',
            'phone' => '081234567891',
            'package_id' => $package->id,
            'event_date' => now()->addDays(45),
            'event_time' => '14:00:00',
            'location' => 'Bandung',
            'city' => 'Bandung',
            'subtotal' => $package->price,
            'pay_now' => $package->price,
            'status' => 'pending',
            'notes' => 'Test booking for reject function'
        ]);

        echo "Test bookings created successfully!\n";
    }
}