<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $buyer;
    protected $seller;
    protected $variant;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buyer = User::factory()->create(['role' => 'buyer']);
        $this->seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $this->seller->id]);
        $this->variant = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'TEST-SKU',
            'price' => 50.00,
            'stock' => 10,
        ]);
    }

    public function test_buyer_can_complete_order_flow(): void
    {
        // 1. Add to cart
        $response = $this->actingAs($this->buyer)
            ->postJson('/api/cart/items', [
                'product_variant_id' => $this->variant->id,
                'qty' => 2
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('cart_items', ['quantity' => 2]);

        // 2. Checkout (Create Order)
        $response = $this->actingAs($this->buyer)
            ->postJson('/api/orders');

        $response->assertStatus(201)
            ->assertJsonPath('total', "100.00") // 50 * 2
            ->assertJsonPath('status', 'pending');

        $this->assertDatabaseHas('orders', [
            'buyer_id' => $this->buyer->id,
            'total' => 100.00
        ]);

        // Verify stock deduction
        $this->variant->refresh();
        $this->assertEquals(8, $this->variant->stock);

        // Verify commission creation
        $this->assertDatabaseHas('commissions', [
            'seller_id' => $this->seller->id,
            'amount' => 10.00 // 10% of 100
        ]);

        // Verify cart is cleared
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_cannot_order_more_than_stock(): void
    {
        // Add more than stock to cart
        $response = $this->actingAs($this->buyer)
            ->postJson('/api/cart/items', [
                'product_variant_id' => $this->variant->id,
                'qty' => 11
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('message', 'Insufficient stock');
    }
}
