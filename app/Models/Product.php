<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'price',
        'area',
        'color',
        'created_at',
        'updated_at'
    ];

    public function properties()
    {
        return $this->hasMany(ProductProperty::class);
    }

    /**
     * Save product with properties
     *
     * @param array $productData
     * @param $propertyData
     * @return bool
     */
    public function saveProduct(array $productData, $propertyData)
    {
        $saveProduct = $this->create($productData);
        if($saveProduct && !empty($propertyData)) {

            $productProperty = new ProductProperty();
            $propertyData = $productProperty->addProductId($saveProduct->id, $propertyData);

            return $productProperty->insert($propertyData);
        } elseif ($saveProduct && empty($propertyData)) {
            return $saveProduct;
        } else {
            return false;
        }
    }

    /**
     * Update product with properties
     *
     * @param int $id
     * @param array $productData
     * @param $propertyData
     * @return bool
     */
    public function updateProduct(int $id, array $productData, $propertyData)
    {
        $product = $this->find($id);
        if($product) {
            $updateProduct = $product->update($productData);


            $productProperty = new ProductProperty();
            $productProperty->where('product_id', $id)->delete();

            if($updateProduct && !empty($propertyData)) {

                $propertyData = $productProperty->addProductId($id, $propertyData);
                return $productProperty->insert($propertyData);
            }
        }

        return false;


    }

    /**
     * Search products by name
     *
     * @param string $name
     * @return mixed
     */
    public function searchByName(string $name)
    {
        return $this->where('name', 'like', '%' . $name . '%')
            ->with('properties')
            ->get();
    }
}
