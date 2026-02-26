<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();

      $table->foreignId('user_id')->constrained()->cascadeOnDelete();

      // order id yang dikirim ke Midtrans (harus unik)
      $table->string('order_id')->unique();

      $table->integer('subtotal')->default(0);
      $table->integer('shipping_cost')->default(0);
      $table->integer('grand_total')->default(0);

      // data pengiriman (ambil dari form checkout)
      $table->string('customer_name')->nullable();
      $table->string('customer_phone')->nullable();
      $table->string('customer_email')->nullable();
      $table->text('shipping_address')->nullable();
      $table->text('notes')->nullable();

      // midtrans
      $table->string('snap_token')->nullable();
      $table->string('payment_type')->nullable();
      $table->string('transaction_status')->default('pending'); // pending|settlement|capture|deny|expire|cancel
      $table->string('fraud_status')->nullable();
      $table->string('status')->default('pending'); // status internal: pending|paid|failed|expired|cancelled

      $table->timestamp('paid_at')->nullable();
      $table->json('midtrans_payload')->nullable(); // simpan respon callback biar gampang debug

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('transactions');
  }
};
