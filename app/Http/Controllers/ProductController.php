<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * List of products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('properties')->get();
        return view('admin.index', [
            'products' => $products
        ]);
    }

    /**
     * Create new product page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Edit product page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return $product
            ? view('admin.create', ['product' => $product])
            : redirect()->route('product.index');
    }

    /**
     * Delete product
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $product = Product::find($id);
        if($product) {
            $product->delete();
        }

        return redirect()->route('product.index');
    }

    /**
     * Update or create product to db
     *
     * @param StoreProductRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request, $id = null)
    {
        $productData    = $request->get('product');
        $propertyData = $request->get('property');

        $product = new Product();
        $savedOrUpdated = $id
            ? $product->updateProduct($id, $productData, $propertyData)
            : $product->saveProduct($productData, $propertyData);

        if(!$savedOrUpdated) {
            $id
                ? redirect()->route('product.edit',[$product])
                : redirect()->route('product.create');
        }

        return redirect()->route('product.index');
    }

    /**
     * Search product by name
     *
     * @param string $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function search(string $name = '')
    {
        try {
            $products = (new Product())->searchByName($name);

            return view('admin.index', [
                'products'    => $products,
                'searchValue' => $name
            ]);
        } catch (\Exception $e) {
            return redirect()->route('product.index');
        }
    }
}
