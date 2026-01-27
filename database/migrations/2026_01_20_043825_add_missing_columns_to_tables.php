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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) $table->string('phone')->nullable();
            if (!Schema::hasColumn('users', 'last_login_at')) $table->timestamp('last_login_at')->nullable();
            if (!Schema::hasColumn('users', 'last_login_ip')) $table->string('last_login_ip')->nullable();
            if (!Schema::hasColumn('users', 'is_active')) $table->boolean('is_active')->default(true);
        });

        Schema::table('participants', function (Blueprint $table) {
            if (!Schema::hasColumn('participants', 'phone')) $table->string('phone')->nullable();
            if (!Schema::hasColumn('participants', 'email')) $table->string('email')->nullable();
            if (!Schema::hasColumn('participants', 'address')) $table->text('address')->nullable();
            if (!Schema::hasColumn('participants', 'birth_date')) $table->date('birth_date')->nullable();
            if (!Schema::hasColumn('participants', 'gender')) $table->string('gender')->nullable();
            if (!Schema::hasColumn('participants', 'created_by')) $table->unsignedBigInteger('created_by')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'description')) $table->text('description')->nullable();
            if (!Schema::hasColumn('categories', 'is_active')) $table->boolean('is_active')->default(true);
            if (!Schema::hasColumn('categories', 'created_by')) $table->unsignedBigInteger('created_by')->nullable();
        });

        Schema::table('regions', function (Blueprint $table) {
            if (!Schema::hasColumn('regions', 'code')) $table->string('code')->nullable();
            if (!Schema::hasColumn('regions', 'description')) $table->text('description')->nullable();
            if (!Schema::hasColumn('regions', 'province')) $table->string('province')->nullable();
            if (!Schema::hasColumn('regions', 'is_active')) $table->boolean('is_active')->default(true);
            if (!Schema::hasColumn('regions', 'created_by')) $table->unsignedBigInteger('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'last_login_at', 'last_login_ip', 'is_active']);
        });
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email', 'address', 'birth_date', 'gender', 'created_by']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_active', 'created_by']);
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn(['code', 'description', 'province', 'is_active', 'created_by']);
        });
    }
};
