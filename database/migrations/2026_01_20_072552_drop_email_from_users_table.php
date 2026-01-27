<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table without the email column
        if ($this->isSqlite()) {
            $this->recreateUsersTableWithoutEmail();
        } else {
            // For other databases, use the standard approach
            if (DB::getSchemaBuilder()->hasColumn('users', 'email')) {
                DB::statement('ALTER TABLE users DROP COLUMN email');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For SQLite, we need to add the column back to the table
        if ($this->isSqlite()) {
            if (!$this->columnExists('users', 'email')) {
                DB::statement('ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL');
                DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email)');
            }
        } else {
            if (!DB::getSchemaBuilder()->hasColumn('users', 'email')) {
                DB::statement('ALTER TABLE users ADD email VARCHAR(255) NULL');
                DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email)');
            }
        }
    }
    
    /**
     * Check if the database driver is SQLite
     */
    private function isSqlite(): bool
    {
        return DB::getDriverName() === 'sqlite';
    }
    
    /**
     * Check if a column exists in a table
     */
    private function columnExists(string $table, string $column): bool
    {
        $columns = DB::select("PRAGMA table_info({$table})");
        foreach ($columns as $col) {
            if ($col->name === $column) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Recreate users table without email column for SQLite
     */
    private function recreateUsersTableWithoutEmail(): void
    {
        // Get the current data
        $users = DB::select('SELECT id, name, password, remember_token, role, region_id, phone, last_login_at, last_login_ip, is_active, current_session_id, created_at, updated_at FROM users');
        
        // Drop the existing table
        
        DB::statement('ALTER TABLE users RENAME TO users_backup');
        
        // Create the new table without email
        DB::statement('CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            remember_token VARCHAR(100) NULL,
            role VARCHAR(255) DEFAULT \'umum\',
            region_id BIGINT UNSIGNED NULL,
            phone VARCHAR(20) NULL,
            last_login_at TIMESTAMP NULL,
            last_login_ip VARCHAR(45) NULL,
            is_active BOOLEAN DEFAULT 1,
            current_session_id VARCHAR(255) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL
        )');
        
        // Add foreign key constraint for region_id
        DB::statement('CREATE INDEX users_region_id_index ON users (region_id)');
        
        // Insert the data back
        foreach ($users as $user) {
            DB::insert('INSERT INTO users (id, name, password, remember_token, role, region_id, phone, last_login_at, last_login_ip, is_active, current_session_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $user->id,
                $user->name,
                $user->password,
                $user->remember_token,
                $user->role ?? 'umum',
                $user->region_id,
                $user->phone,
                $user->last_login_at,
                $user->last_login_ip,
                $user->is_active ?? 1,
                $user->current_session_id,
                $user->created_at,
                $user->updated_at
            ]);
        }
        
        // Drop backup table
        
    }
};
