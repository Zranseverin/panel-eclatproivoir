<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class NewsletterSubscriberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_newsletter_subscribers()
    {
        // Create an admin user
        $admin = Admin::factory()->create([
            'nom_complet' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        // Acting as the admin user
        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.newsletter-subscribers.index'));

        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewHas('subscribers');
    }

    /** @test */
    public function it_can_update_a_subscriber_status()
    {
        // Create an admin user
        $admin = Admin::factory()->create([
            'nom_complet' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $subscriber = NewsletterSubscriber::factory()->create([
            'is_active' => true,
        ]);
        
        // Acting as the admin user
        $response = $this->actingAs($admin, 'admin')
                         ->put(route('admin.newsletter-subscribers.update', $subscriber), [
                             'is_active' => 0,
                         ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('newsletter_subscribers', [
            'id' => $subscriber->id,
            'is_active' => 0,
        ]);
    }

    /** @test */
    public function it_can_delete_a_subscriber()
    {
        // Create an admin user
        $admin = Admin::factory()->create([
            'nom_complet' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $subscriber = NewsletterSubscriber::factory()->create();
        
        // Acting as the admin user
        $response = $this->actingAs($admin, 'admin')
                         ->delete(route('admin.newsletter-subscribers.destroy', $subscriber));

        $response->assertRedirect();
        $this->assertDatabaseMissing('newsletter_subscribers', [
            'id' => $subscriber->id,
        ]);
    }
}