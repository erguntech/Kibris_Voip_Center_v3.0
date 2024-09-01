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
        Schema::create('asterisk_call_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('call_center_client_id')->nullable();
            $table->string('source')->nullable();
            $table->string('destination')->nullable();
            $table->string('call_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asterisk_call_logs');
    }
};
