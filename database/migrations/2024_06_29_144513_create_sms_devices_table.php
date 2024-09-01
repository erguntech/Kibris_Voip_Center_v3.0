<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('gsm_api_token')->nullable();
            $table->integer('assigned_client_id')->nullable();
            $table->integer('credit_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_devices');
    }
};
