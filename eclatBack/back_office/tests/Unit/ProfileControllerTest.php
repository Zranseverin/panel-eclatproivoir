<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_update_admin_profile()
    {
        // Create an admin user
        $admin = Admin::factory()->create([
            'nom_complet' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        // Acting as the admin user
        $response = $this->actingAs($admin, 'admin')
                         ->put(route('admin.profile.update'), [
                             'nom_complet' => 'Updated Admin',
                             'numero' => '123456789',
                             'email' => 'updated@example.com'
                         ]);

        // Assert redirection
        $response->assertRedirect(route('admin.profile.edit'));

        // Assert the admin was updated in the database
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'nom_complet' => 'Updated Admin',
            'numero' => '123456789',
            'email' => 'updated@example.com'
        ]);
    }
}