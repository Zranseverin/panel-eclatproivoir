<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavbarBrand;

class NavbarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        NavbarBrand::truncate();

        // Create default brand configuration
        NavbarBrand::create([
            'logo_path' => 'img/logo.jpg',
            'logo_alt' => 'eclat pro ivoir',
            'brand_name' => 'EPI - Eclat pro Ivoire',
            'brand_url' => 'index.php',
            'logo_height' => 100,
            'is_active' => true,
        ]);

        $this->command->info('Navbar brand configuration seeded successfully!');
    }
}
