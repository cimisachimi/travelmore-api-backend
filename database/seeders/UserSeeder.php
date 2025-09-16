<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the user already exists to avoid duplicates
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'adam',
                'email' => 'adamhuzaini@gmail.com',
                'password' => Hash::make('Adam@135'), // <-- CHANGE THIS!
            ]);
        }
    }
}