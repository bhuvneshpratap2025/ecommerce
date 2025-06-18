<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_a_product_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('cart.add', $product));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product added to cart!');

        $this->assertEquals(session('cart')[$product->id]['name'], $product->name);
        $this->assertEquals(session('cart')[$product->id]['quantity'], 1);
    }

    /** @test */
    public function adding_same_product_increases_quantity()
    {
        $product = Product::factory()->create();

        // Add once
        $this->post(route('cart.add', $product));
        // Add again
        $this->post(route('cart.add', $product));

        $this->assertEquals(session('cart')[$product->id]['quantity'], 2);
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $product = Product::factory()->create();

        // Add first
        $this->post(route('cart.add', $product));
        $this->assertArrayHasKey($product->id, session('cart'));

        // Remove
        $response = $this->delete(route('cart.remove', $product));
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product removed from cart!');

        $this->assertArrayNotHasKey($product->id, session('cart'));
    }

    /** @test */
    public function user_can_view_cart_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertViewIs('cart.index');
        $response->assertViewHasAll(['cart', 'wishlist']);
    }
}
