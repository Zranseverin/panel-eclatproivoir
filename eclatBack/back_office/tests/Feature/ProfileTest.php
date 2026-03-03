<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_their_profile()
    {
        // Create an admin user
        $admin = Admin::factory()->create([
            'nom_complet' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        // Acting as the admin user
        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.profile.index'));

        // Assert successful response
        $response->assertStatus(200);
        
        // Assert that the admin's name is displayed
        $response->assertSee('Test Admin');
    }

    /** @test */
    public function admin_can_view_edit_profile_page()
    {
        // Create an admin user
        $admin = Admin::factory()->create([
            'nom_complet' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        // Acting as the admin user
        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.profile.edit'));

        // Assert successful response
        $response->assertStatus(200);
        
        // Assert that the edit form is displayed
        $response->assertSee('Modifier mon profil');
    }
}