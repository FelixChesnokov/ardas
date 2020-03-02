<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductProperty;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPropetryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddProductId()
    {
        $productId = 1;

        $propertyData = [
            [
                'name'       => 'size',
                'value'      => 200
            ],
            [
                'name'       => 'power',
                'value'      => '30'
            ],
        ];

        $needResult = [
            [
                'product_id' => 1,
                'name'       => 'size',
                'value'      => 200
            ],
            [
                'product_id' => 1,
                'name'       => 'power',
                'value'      => '30'
            ],
        ];

        $result = (new ProductProperty())->addProductId($productId, $propertyData);

        $this->assertEquals($result, $needResult);
    }

    public function testAddProductIdEmptyPropertyData()
    {
        $productId = 1;

        $propertyData = [];

        $needResult = [];

        $result = (new ProductProperty())->addProductId($productId, $propertyData);

        $this->assertEquals($result, $needResult);
    }

    public function testAddProductIdNullProductId()
    {
        $productId = null;

        $propertyData = [];

        $this->expectExceptionMessage('Argument 1 passed to App\Models\ProductProperty::addProductId() must be of the type int');

        (new ProductProperty())->addProductId($productId, $propertyData);
    }
}
