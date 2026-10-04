<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_are_visible_without_logging_in(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        Product::create(['seller_id' => $seller->id, 'name' => 'চা পাতা', 'price' => 120, 'stock' => 4]);

        $this->get('/')->assertOk()->assertSee('চা পাতা')->assertSee('অর্ডার করতে লগইন');
    }

    public function test_language_can_be_switched_between_bengali_and_english(): void
    {
        $this->from('/')->get(route('language.switch', 'en'))->assertRedirect('/');
        $this->get('/')->assertOk()->assertSee('Order products you love')->assertSee('<html lang="en">', false);

        $this->from('/')->get(route('language.switch', 'bn'))->assertRedirect('/');
        $this->get('/')->assertOk()->assertSee('পছন্দের পণ্য অর্ডার করুন')->assertSee('<html lang="bn">', false);
    }

    public function test_buyer_can_order_and_stock_is_reduced(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = Product::create(['seller_id' => $seller->id, 'name' => 'চা পাতা', 'price' => 120, 'stock' => 4]);

        $this->actingAs($buyer)->post(route('orders.store', $product), ['quantity' => 2])
            ->assertRedirect(route('buyer.orders'));

        $this->assertDatabaseHas('orders', ['buyer_id' => $buyer->id, 'product_id' => $product->id, 'quantity' => 2, 'total' => 240]);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 2]);
    }

    public function test_seller_can_add_product_and_see_their_dashboard(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);

        $this->actingAs($seller)->post(route('seller.products.store'), [
            'name' => 'মধু', 'description' => 'খাঁটি মধু', 'price' => 450, 'stock' => 5,
        ])->assertRedirect();

        $this->get(route('seller.dashboard'))->assertOk()->assertSee('মধু');
        $this->withSession(['locale' => 'en'])->get(route('seller.dashboard'))
            ->assertOk()->assertSee('Seller panel')->assertSee('Add a product');
        $this->assertDatabaseHas('products', ['seller_id' => $seller->id, 'name' => 'মধু']);
    }
}