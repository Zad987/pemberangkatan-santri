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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action'); // CREATE, UPDATE, DELETE, VIEW, LOGIN, LOGOUT
            $table->string('model_type')->nullable(); // Participant, Payment, User, etc.
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('old_values')->nullable(); // Before changes
            $table->json('new_values')->nullable(); // After changes
            $table->text('description')->nullable(); // Human readable description
            $table->string('severity')->default('info'); // info, warning, danger
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id']);
            $table->index(['action']);
            $table->index(['model_type', 'model_id']);
            $table->index(['created_at']);
            $table->index(['severity']);
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