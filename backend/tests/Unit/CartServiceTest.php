<?php

namespace Tests\Unit;

use App\Services\CartService;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    public function test_add_item_to_empty_cart()
    {
        $service = new CartService();
        $cart = $service->addItem([], 1, 2);
        $this->assertArrayHasKey('produit_1', $cart);
        $this->assertEquals(2, $cart['produit_1']['quantite']);
    }

    public function test_add_same_item_increments_quantity()
    {
        $service = new CartService();
        $cart = ['produit_1' => ['quantite' => 1, 'prix' => 50]];
        $cart = $service->addItem($cart, 1, 3);
        $this->assertEquals(4, $cart['produit_1']['quantite']);
    }

    public function test_update_item_quantity()
    {
        $service = new CartService();
        $cart = ['produit_1' => ['quantite' => 1, 'prix' => 50]];
        $cart = $service->updateItem($cart, 1, 5);
        $this->assertEquals(5, $cart['produit_1']['quantite']);
    }

    public function test_remove_item()
    {
        $service = new CartService();
        $cart = ['produit_1' => ['quantite' => 1, 'prix' => 50]];
        $cart = $service->removeItem($cart, 1);
        $this->assertArrayNotHasKey('produit_1', $cart);
    }

    public function test_calculate_totals()
    {
        $service = new CartService();
        $cart = [
            'produit_1' => ['prix' => 50, 'quantite' => 2],
            'produit_2' => ['prix' => 30, 'quantite' => 1],
        ];
        $result = $service->calculateTotals($cart);
        $this->assertEquals(130, $result['total']);
        $this->assertEquals(2, $result['count']);
    }
}
