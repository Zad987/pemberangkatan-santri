<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'pengembang'],
            [
                'name' => 'Pengembang',
                'password' => Hash::make('PPMHA5758'),
                'role' => 'induk', // Admin role
                'region_id' => null, // Admin doesn't belong to a specific region
            ]
        );
    }
}