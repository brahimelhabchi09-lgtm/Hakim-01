<?php

namespace Tests\Unit;

use App\DTOs\CartItemData;
use App\DTOs\CheckoutData;
use App\DTOs\FilterData;
use Tests\TestCase;

class DTOsTest extends TestCase
{
    public function test_cart_item_data()
    {
        $dto = new CartItemData(1, 'Product', 50.0, 2, '/img.jpg');
        $this->assertEquals(100.0, $dto->getSubtotal());
    }

    public function test_cart_item_to_array()
    {
        $dto = new CartItemData(1, 'Product', 50.0, 2);
        $array = $dto->toArray();
        $this->assertArrayHasKey('subtotal', $array);
        $this->assertEquals(100.0, $array['subtotal']);
    }

    public function test_filter_data_from_request()
    {
        $filter = FilterData::fromRequest(['search' => 'test', 'page' => 2]);
        $this->assertEquals('test', $filter->search);
        $this->assertEquals(2, $filter->page);
    }

    public function test_checkout_data_from_request()
    {
        $data = CheckoutData::fromRequest([
            'items' => [],
            'adresse_livraison' => '123 St',
            'ville' => 'City',
        ]);
        $this->assertEquals('123 St', $data->adresseLivraison);
    }
}
