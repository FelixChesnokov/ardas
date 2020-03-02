<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductProperty;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSaveProduct()
    {
        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $propertyData = [
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

        // do not see
        $this->assertDatabaseMissing('products', $productData);
        $this->assertDatabaseMissing('product_properties', $propertyData[0]);
        $this->assertDatabaseMissing('product_properties', $propertyData[1]);

        (new Product())->saveProduct($productData, $propertyData);

        // see
        $this->assertDatabaseHas('products', $productData);
        $this->assertDatabaseHas('product_properties', $propertyData[0]);
        $this->assertDatabaseHas('product_properties', $propertyData[1]);

    }

    public function testSaveProductEmptyPropetry()
    {
        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $propertyData = [];

        // do not see
        $this->assertDatabaseMissing('products', $productData);
        $this->assertNull(ProductProperty::first());

        (new Product())->saveProduct($productData, $propertyData);

        // see
        $this->assertDatabaseHas('products', $productData);
        $this->assertNull(ProductProperty::first());

    }

    public function testSaveProductNullPropetry()
    {
        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $propertyData = null;

        // do not see
        $this->assertDatabaseMissing('products', $productData);
        $this->assertNull(ProductProperty::first());

        (new Product())->saveProduct($productData, $propertyData);

        // see
        $this->assertDatabaseHas('products', $productData);
        $this->assertNull(ProductProperty::first());

    }

    public function testSaveProductEmptyProduct()
    {
        $productData = [];

        $propertyData = [];

        // do not see
        $this->assertNull(Product::first());
        $this->assertNull(ProductProperty::first());

        $this->expectExceptionMessage("Field 'name' doesn't have a default value");

        (new Product())->saveProduct($productData, $propertyData);
    }


    // updating
    public function testUpdateProduct()
    {
        $id = 1;

        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $propertyDataBefore = [
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

        $propertyDataAfter = [
            [
                'product_id' => 1,
                'name'       => 'size2',
                'value'      => 2001
            ],
            [
                'product_id' => 1,
                'name'       => 'power2',
                'value'      => '301'
            ],
        ];

        (new Product())->saveProduct($productData, $propertyDataBefore);

        // do not see
        $this->assertDatabaseHas('products', $productData);
        $this->assertDatabaseHas('product_properties', $propertyDataBefore[0]);
        $this->assertDatabaseHas('product_properties', $propertyDataBefore[1]);

        (new Product())->updateProduct($id, $productData, $propertyDataAfter);

        // see
        $this->assertDatabaseHas('products', $productData);
        $this->assertDatabaseHas('product_properties', $propertyDataAfter[0]);
        $this->assertDatabaseHas('product_properties', $propertyDataAfter[1]);
    }

    public function testUpdateProductEmptyProperty()
    {
        $id = 1;

        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $propertyDataBefore = [
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

        $propertyDataAfter = [];

        (new Product())->saveProduct($productData, $propertyDataBefore);

        // do not see
        $this->assertDatabaseHas('products', $productData);
        $this->assertDatabaseHas('product_properties', $propertyDataBefore[0]);
        $this->assertDatabaseHas('product_properties', $propertyDataBefore[1]);

        (new Product())->updateProduct($id, $productData, $propertyDataAfter);

        // see
        $this->assertDatabaseHas('products', $productData);
        $this->assertDatabaseMissing('product_properties', $propertyDataBefore[0]);
        $this->assertDatabaseMissing('product_properties', $propertyDataBefore[1]);
    }

    public function testUpdateProductNullProductId()
    {
        $id = null;

        $productData = [];

        $propertyData = [];

        $this->expectExceptionMessage("Argument 1 passed to App\Models\Product::updateProduct() must be of the type int, null given");

        (new Product())->updateProduct($id, $productData, $propertyData);
    }

    public function testSearchByName()
    {
        $name = 'test';

        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $product = new Product();
        $product->saveProduct($productData, []);

        $searched = $product->searchByName($name);

        $this->assertEquals($productData['name'], $searched[0]->name);
    }

    public function testSearchByEmptyName()
    {
        $name = '';

        $productData = [
            'id'    => '1',
            'name'  => 'testProduct',
            'price' => 12,
            'area'  => 31,
            'color' => 'black',
        ];

        $product = new Product();
        $product->saveProduct($productData, []);

        $searched = $product->searchByName($name);

        $this->assertEquals($productData['name'], $searched[0]->name);
    }
}
