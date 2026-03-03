<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;

class NewsletterSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 50 newsletter subscribers
        NewsletterSubscriber::factory()->count(50)->create();
        
        // Create some specific subscribers for testing
        NewsletterSubscriber::factory()->active()->create([
            'email' => 'active@example.com',
            'subscribed_at' => now()->subDays(10),
        ]);
        
        NewsletterSubscriber::factory()->inactive()->create([
            'email' => 'inactive@example.com',
            'subscribed_at' => now()->subDays(5),
        ]);
    }
}