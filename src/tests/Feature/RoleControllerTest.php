<?php

namespace Tests\Feature;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role and user
        Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $this->superadmin = User::factory()->create();
        $this->superadmin->assignRole('super-admin');
    }

    /** @test */
    public function admin_can_view_roles_index()
    {
        $this->actingAs($this->superadmin);
        $response = $this->get(route('roles.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.roles.index');
        $response->assertViewHas('roles');
    }
     /** @test */
    public function admin_can_access_role_creation_form()
    {
        $this->actingAs($this->superadmin);
        $response = $this->get(route('roles.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.roles.create');
    }
    
    /** @test */
    public function admin_can_create_a_role()
    {
        $this->actingAs($this->superadmin);

        $response = $this->post(route('roles.store'), [
            'name' => 'manager',
        ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'manager']);
    }
    
    /** @test */
    public function admin_can_access_edit_form_for_a_role()
    {
        $this->actingAs($this->superadmin);

        $role = Role::create(['name' => 'editor', 'guard_name' => 'web']);
        $response = $this->get(route('roles.edit', $role));

        $response->assertStatus(200);
        $response->assertViewIs('admin.roles.edit');
        $response->assertViewHas('role', $role);
    }

    /** @test */
    public function admin_can_update_a_role()
    {
        $this->actingAs($this->superadmin);

        $role = Role::create(['name' => 'writer', 'guard_name' => 'web']);
        $response = $this->put(route('roles.update', $role), [
            'name' => 'updated-writer',
        ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'updated-writer']);
    }

    /** @test */
    public function admin_can_delete_a_role()
    {
        $this->actingAs($this->superadmin);

        $role = Role::create(['name' => 'temp-role', 'guard_name' => 'web']);
        $response = $this->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
