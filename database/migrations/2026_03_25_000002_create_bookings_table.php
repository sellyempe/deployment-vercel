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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trip_id');
            $table->integer('participants')->default(1)->comment('Jumlah peserta');
            $table->date('preferred_date')->nullable()->comment('Tanggal perjalanan yang diinginkan');
            $table->string('phone')->nullable()->comment('Nomor telepon kontak');
            $table->text('special_request')->nullable()->comment('Catatan atau permintaan khusus');
            $table->decimal('total_price', 15, 2)->comment('Harga total dalam Rupiah');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->string('order_id')->unique()->comment('Format: PINK-{booking_id}-{timestamp}');
            $table->timestamp('confirmed_at')->nullable()->comment('Waktu konfirmasi pembayaran');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->index('status');
            $table->index('order_id');
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
