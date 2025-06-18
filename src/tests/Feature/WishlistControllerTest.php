<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use Mockery;

class WishlistControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
        /** @test */
    public function user_can_add_product_to_wishlist()
    {
        
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
             ->post('/wishlist', ['product_id' => $product->id])
             ->assertRedirect()
             ->assertSessionHas('success', 'Added to wishlist.');

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
        /** @test */
    public function user_can_remove_product_from_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($user)
             ->delete("/wishlist/{$product->id}")
             ->assertRedirect()
             ->assertSessionHas('success', 'Removed from wishlist.');

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
    /** @test */
    public function user_can_view_their_wishlist()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->get('/wishlist')
             ->assertStatus(200)
             ->assertViewIs('wishlist.index');
    }
        /** @test */
    public function user_can_move_product_from_wishlist_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

         // Create wishlist entry
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // Mock CartController's add method
        $mockCartController = \Mockery::mock(\App\Http\Controllers\CartController::class);
        $mockCartController->shouldReceive('add')->once();

        $this->app->instance(\App\Http\Controllers\CartController::class, $mockCartController);

        $this->actingAs($user)
             ->post('/wishlist/wishlisttocart', ['product_id' => $product->id])
             ->assertRedirect()
             ->assertSessionHas('success', 'Added from wishlist.');

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
