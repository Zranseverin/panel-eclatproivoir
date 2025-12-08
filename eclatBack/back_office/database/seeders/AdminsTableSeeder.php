<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test admin user with known credentials
        Admin::create([
            'nom_complet' => 'Test Administrator',
            'numero' => '12345678',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'), // Password: admin123
        ]);
    }
}