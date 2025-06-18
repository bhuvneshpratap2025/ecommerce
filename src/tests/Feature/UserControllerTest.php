<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'default']);

        // Create users
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super-admin');
    }

    /** @test */
    public function super_admin_can_view_users_index()
    {
        $response = $this->actingAs($this->superAdmin)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    /** @test */
    public function admin_can_view_users_index()
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    /** @test */
    public function unauthorized_user_cannot_view_users_index()
    {
        $user = User::factory()->create(); // No role
        $response = $this->actingAs($user)->get(route('users.index'));
        $response->assertStatus(403); // Because of `die()`
    }

    /** @test */
    public function admin_can_create_a_user()
    {
        $response = $this->actingAs($this->admin)->post(route('users.store'), [
            'name' => 'John Doe New',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => Role::where('name', 'default')->first()->id,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /** @test */
    public function admin_can_edit_a_user()
    {
        $user = User::factory()->create();
        $user->assignRole('default');

        $response = $this->actingAs($this->admin)->get(route('users.edit', $user));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user');
        $response->assertViewHas('roles');
    }

    /** @test */
    public function admin_can_update_a_user()
    {
        $user = User::factory()->create(['name' => 'Old Name', 'email' => 'old@example.com']);
        $user->assignRole('default');

        $response = $this->actingAs($this->admin)->put(route('users.update', $user), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'role' => Role::where('name', 'default')->first()->id,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    /** @test */
    public function admin_can_delete_a_user()
    {
        $user = User::factory()->create();
        $this->actingAs($this->superAdmin);

        $response = $this->actingAs($this->superAdmin)->delete(route('users.destroy', $user));
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
