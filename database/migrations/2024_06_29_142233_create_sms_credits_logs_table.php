<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_credits_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('credit_type')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('device_id')->nullable();
            $table->integer('owned_credits')->nullable();
            $table->integer('credit_to_add')->nullable();
            $table->integer('credits_summary')->nullable();
            $table->integer('payment_order_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_credits_logs');
    }
};
