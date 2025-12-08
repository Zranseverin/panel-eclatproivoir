<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nom_complet' => 'Administrateur Principal',
            'numero' => '0000000000',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}