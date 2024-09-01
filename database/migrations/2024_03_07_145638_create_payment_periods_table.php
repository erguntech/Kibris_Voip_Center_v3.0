<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->date('payment_start_date')->nullable();
            $table->float('payment_amount')->nullable();
            $table->string('currency')->nullable();
            $table->boolean('show_delayed_payment_warnings')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_periods');
    }
};
