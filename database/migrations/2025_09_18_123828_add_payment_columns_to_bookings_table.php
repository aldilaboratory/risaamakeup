<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_status')->default('unpaid'); // unpaid|pending|paid|failed|expired|cancel
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->string('midtrans_va_number')->nullable();
            $table->string('midtrans_pdf_url')->nullable();
            $table->json('midtrans_payload')->nullable();
        });
    }
    
    public function down(): void {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
            'payment_status','midtrans_order_id','midtrans_transaction_id',
            'midtrans_payment_type','midtrans_va_number','midtrans_pdf_url','midtrans_payload'
            ]);
        });
    }

};
