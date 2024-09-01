<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->date('order_creation_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('approve_date')->nullable();
            $table->float('payment_amount')->nullable();
            $table->string('currency')->nullable();
            $table->integer('status')->default(1);
            $table->integer('invoice_type')->default(1); // 1 Aylık Aidat, 2 SMS
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};
