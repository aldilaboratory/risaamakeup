<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // relasi ke packages
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // info pelanggan
            $table->string('name');
            $table->string('phone');
            $table->string('city')->nullable();
            $table->string('location');
            $table->date('event_date');
            $table->time('event_time');

            // order detail
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('dp_percent')->default(100);
            $table->unsignedBigInteger('subtotal');   // total harga paket x qty
            $table->unsignedBigInteger('pay_now');    // nominal yang dibayar saat booking
            $table->text('notes')->nullable();

            // status pesanan
            $table->enum('status', ['pending','confirmed','canceled','done'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
