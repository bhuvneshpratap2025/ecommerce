<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // Create roles for the tests
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'super-admin']);
    }
    /** @test */
    public function guest_can_view_products_index()
    {
        $response = $this->get(route('products.productlist'));

        $response->assertStatus(200);
        $response->assertViewHasAll(['products', 'wishlist']);
    }
    /** @test */
    public function admin_can_view_products_index()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHasAll(['products', 'wishlist']);
    }
    /** @test */
    public function can_view_create_product_form()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewHas('categories');
        $response->assertViewIs('admin.products.create');
    }
    /** @test */
    public function can_store_valid_product()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $productData = [
            'name' => 'Valid Product Name',
            'description' => str_repeat('x', 255),
            'price' => 100,
            'stock' => 10,
        ];

        $response = $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Valid Product Name']);
    }
    

    /** @test */
    public function store_fails_with_invalid_data()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->post(route('products.store'), []);

        $response->assertSessionHasErrors(['name', 'description', 'price', 'stock']);
    }

    

    /** @test */
    public function can_view_edit_form()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertViewHasAll(['product', 'categories']);
        $response->assertViewIs('admin.products.edit');
    }

    /** @test */
    public function can_update_product()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $product = Product::factory()->create();

        $updateData = [
            'name' => 'Updated Product Name',
            'price' => 150,
        ];

        $response = $this->actingAs($user)->put(route('products.update', $product->id), $updateData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product Name']);
    }

    /** @test */
    public function update_fails_with_invalid_data()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $product = Product::factory()->create();

        $updateData = [
            'name' => 'Short',  // less than min:10 chars
        ];

        $response = $this->actingAs($user)->put(route('products.update', $product->id), $updateData);

        $response->assertSessionHasErrors(['name']);
    }
    /** @test */
    public function can_delete_product()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
   /** @test */
    public function can_show_single_product()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => 'success']);
    }
}
