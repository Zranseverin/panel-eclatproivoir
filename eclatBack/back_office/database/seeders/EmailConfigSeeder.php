<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailConfig;

class EmailConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailConfig::create([
            'host' => 'smtp.gmail.com',
            'username' => 'fleetmove82@gmail.com',
            'password' => 'vxriftlhszoyuogy',
            'encryption' => 'tls',
            'port' => 587,
            'from_address' => 'fleetmove82@gmail.com',
            'from_name' => 'Eclat Back Office'
        ]);
    }
}
