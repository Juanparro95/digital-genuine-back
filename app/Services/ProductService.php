<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\Interfaces\IProductService;

class ProductService implements IProductService
{
    protected mixed $modelClass;

    public function __construct()
    {
        $this->modelClass = new Product();
    }

    public function createProduct(StoreProductRequest $request)
    {
        $this->modelClass->name = $request->input('name');
        $this->modelClass->description = $request->input('description');
        $this->modelClass->quantity = $request->input('quantity');
        $this->modelClass->category_id = $request->input('category_id');
        $this->modelClass->save();

        return $this->modelClass;
    }

    public function getAllProducts()
    {
        return $this->modelClass::all();
    }

    public function getProductById($id)
    {
        return $this->modelClass::findOrFail($id);
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
        $product = $this->modelClass::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->quantity = $request->input('quantity');
        $product->category_id = $request->input('category_id');
        $product->save();

        return $this->modelClass;
    }

    public function deleteProduct($id)
    {
        $product = $this->modelClass::findOrFail($id);
        $product->delete();

        return $product;
    }
}
