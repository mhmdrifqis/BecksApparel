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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (Pembeli)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Info Transaksi
            $table->string('invoice_number')->unique(); // Contoh: INV-20260125-001
            $table->decimal('total_price', 12, 2);
            
            // Status Order & Pembayaran
            // Pending -> Paid (Sudah Bayar) -> Production (Dijahit) -> Shipping (Dikirim) -> Completed -> Cancelled
            $table->enum('status', ['pending', 'paid', 'production', 'shipping', 'completed', 'returned', 'cancelled'])->default('pending');
            
            // Pembayaran Manual
            $table->enum('payment_status', ['unpaid', 'pending_confirmation', 'paid', 'failed'])->default('unpaid');
            $table->string('payment_proof')->nullable(); // Foto bukti transfer
            
            // Pengiriman
            $table->text('shipping_address');
            $table->string('resi_number')->nullable(); // Resi diisi Admin nanti
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
