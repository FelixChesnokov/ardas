<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    protected $table = 'product_properties';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'product_id',
        'name',
        'value'
    ];

    /**
     * Add product id to array
     *
     * @param int $productId
     * @param array $propertyData
     * @return array
     */
    public function addProductId(int $productId, array $propertyData)
    {
        foreach ($propertyData as $key => $propertyDatum) {
            $propertyData[$key]['product_id'] = $productId;
        }

        return $propertyData;
    }
}
