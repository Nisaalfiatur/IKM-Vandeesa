<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus duplicate users terlebih dahulu
        DB::table('users')->truncate();

        // Insert fresh demo users
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'username' => 'kasir',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ],
            [
                'username' => 'owner',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ],
        ]);
    }
}
