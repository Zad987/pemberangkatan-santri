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
        // Add indexes for better query performance
        Schema::table('participants', function (Blueprint $table) {
            // Index for region-based queries (regional user filtering)
            if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'region_id') || !DB::select("PRAGMA index_list(users)") || !collect(DB::select("PRAGMA index_list(users)"))->contains("name", "users_region_id_index")) {  }
            
            // Index for category-based queries
            $table->index('category_id');
            
            // Composite index for common query patterns
            $table->index(['region_id', 'category_id']);
            
            // Index for name searches
            $table->index('name');
        });
        Schema::table('payments', function (Blueprint $table) {
            // Index for participant-based queries
            $table->index('participant_id');
            
            // Index for status filtering
            $table->index('status');
            
            // Index for date-based queries
            $table->index('payment_date');
            
            // Composite indexes for common query patterns
            $table->index(['participant_id', 'status']);
            $table->index(['participant_id', 'payment_date']);
        });
        // Add indexes to users table if not exists
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'region_id') || !DB::select("PRAGMA index_list(users)") || !collect(DB::select("PRAGMA index_list(users)"))->contains("name", "users_region_id_index")) {  }
            $table->index('role');
            $table->index(['region_id', 'role']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex(['region_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['region_id', 'category_id']);
            $table->dropIndex(['name']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['participant_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_date']);
            $table->dropIndex(['participant_id', 'status']);
            $table->dropIndex(['participant_id', 'payment_date']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['region_id']);
            $table->dropIndex(['role']);
            $table->dropIndex(['region_id', 'role']);
        });
    }
};
