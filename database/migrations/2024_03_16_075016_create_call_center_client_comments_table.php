<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_center_client_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('assigned_user_id')->nullable();
            $table->integer('call_center_client_id')->nullable();
            $table->integer('saved_status_id')->nullable();
            $table->text('comment_content')->nullable();
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
        Schema::dropIfExists('call_center_client_comments');
    }
};
