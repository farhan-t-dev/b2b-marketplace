<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $sellerUser;
    protected $seller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sellerUser = User::factory()->seller()->create();
        $this->seller = Seller::create([
            'user_id' => $this->sellerUser->id,
            'shop_name' => 'Test Shop',
            'status' => 'active',
        ]);
    }

    public function test_seller_can_create_product_with_variants(): void
    {
        $response = $this->actingAs($this->sellerUser)
            ->postJson('/api/seller/products', [
                'title' => 'Test Product',
                'description' => 'Test Description',
                'variants' => [
                    [
                        'sku' => 'SKU-001',
                        'price' => 100.00,
                        'stock' => 10,
                        'attributes' => ['color' => 'Red']
                    ],
                    [
                        'sku' => 'SKU-002',
                        'price' => 110.00,
                        'stock' => 5,
                        'attributes' => ['color' => 'Blue']
                    ]
                ]
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('title', 'Test Product')
            ->assertJsonCount(2, 'variants');

        $this->assertDatabaseHas('products', ['title' => 'Test Product']);
        $this->assertDatabaseHas('product_variants', ['sku' => 'SKU-001']);
    }

    public function test_buyer_cannot_create_product(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)
            ->postJson('/api/seller/products', [
                'title' => 'Test Product',
                'description' => 'Test Description',
                'variants' => [['sku' => 'SKU-001', 'price' => 10, 'stock' => 1]]
            ]);

        $response->assertStatus(403);
    }

    public function test_anyone_can_list_active_products(): void
    {
        Product::factory()->count(3)->create([
            'seller_id' => $this->seller->id,
            'status' => 'active'
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}
