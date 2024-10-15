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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->string('model')->nullable()
                ->comment('The model that was affected by the action');
            $table->unsignedBigInteger('record_id')->nullable()
                ->comment('The record that was affected by the action');
            $table->json('data')->nullable()
                ->comment('The data that was affected by the action');
            $table->unsignedBigInteger('user_id')->nullable()
                ->comment('The user that performed the action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
