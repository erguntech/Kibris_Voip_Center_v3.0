<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_modules', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->boolean('sms_module')->default(false);
            $table->integer('sms_module_device_id')->nullable();
            $table->integer('sms_credits')->nullable()->default(0);
            $table->boolean('pbx_module')->default(true);
            $table->string('pbx_server_ip_address')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_modules');
    }
};
