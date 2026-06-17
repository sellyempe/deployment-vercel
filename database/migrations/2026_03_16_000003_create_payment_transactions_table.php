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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('reference_id')->unique()->comment('Invoice/Order ID');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'processing', 'success', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable()->comment('credit_card, bank_transfer, e_wallet, etc');
            $table->string('gateway')->nullable()->comment('midtrans, xendit, xendit, etc');
            $table->string('gateway_transaction_id')->nullable();
            $table->text('metadata')->nullable()->comment('JSON metadata for payment gateway');
            $table->timestamp('transaction_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('status');
            $table->index('reference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
