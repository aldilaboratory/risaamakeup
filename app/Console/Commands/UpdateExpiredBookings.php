<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status booking yang sudah expired (lebih dari 1 jam) menjadi unpaid';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update booking yang expired...');

        // Cari booking yang pending dan sudah expired
        $expiredBookings = Booking::where('payment_status', 'pending')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('Tidak ada booking yang expired.');
            return 0;
        }

        $count = 0;
        foreach ($expiredBookings as $booking) {
            // Update status menjadi unpaid dan reset token
            $booking->update([
                'payment_status' => 'unpaid',
                'midtrans_snap_token' => null,
                'midtrans_order_id' => null,
            ]);
            $count++;
        }

        $this->info("Berhasil update {$count} booking yang expired menjadi unpaid.");
        return 0;
    }
}
