<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navbar;

class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Navbar::truncate();

        // Create top-level menu items
        $menuItems = [
            [
                'title' => 'Accueil',
                'url' => 'index.php',
                'order' => 1,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'title' => 'A propos',
                'url' => 'about.php',
                'order' => 2,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'title' => 'Service',
                'url' => 'service.php',
                'order' => 3,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'title' => 'Prix',
                'url' => 'price.php',
                'order' => 4,
                'is_active' => true,
                'parent_id' => null,
            ],
        ];

        foreach ($menuItems as $item) {
            Navbar::create($item);
        }

        // Create "Pages" dropdown parent
        $pagesDropdown = Navbar::create([
            'title' => 'Pages',
            'url' => '#',
            'order' => 5,
            'is_active' => true,
            'parent_id' => null,
        ]);

        // Create dropdown items for "Pages"
        $dropdownItems = [
            ['title' => 'Blog Grid', 'url' => 'blog.php', 'order' => 1],
            ['title' => 'Blog Detail', 'url' => 'detail.php', 'order' => 2],
            ['title' => 'The Team', 'url' => 'team.php', 'order' => 3],
            ['title' => 'Testimonial', 'url' => 'testimonial.php', 'order' => 4],
            ['title' => 'Appointment', 'url' => 'appointment.php', 'order' => 5],
            ['title' => 'Search', 'url' => 'search.php', 'order' => 6],
        ];

        foreach ($dropdownItems as $item) {
            Navbar::create([
                'title' => $item['title'],
                'url' => $item['url'],
                'order' => $item['order'],
                'is_active' => true,
                'parent_id' => $pagesDropdown->id,
            ]);
        }

        // Create "Contact" menu item
        Navbar::create([
            'title' => 'Contact',
            'url' => 'contact.php',
            'order' => 6,
            'is_active' => true,
            'parent_id' => null,
        ]);

        $this->command->info('Navbar menu items seeded successfully!');
    }
}
