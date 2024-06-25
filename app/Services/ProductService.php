<?php

namespace App\Services;

use App\Enums\Attributes;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
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
        $this->modelClass->name = $request->input(Attributes::NAME);
        $this->modelClass->description = $request->input(Attributes::DESCRIPTION);
        $this->modelClass->quantity = $request->input(Attributes::QUANTITY);
        $this->modelClass->category_id = $request->input(Attributes::CATEGORY_ID);
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
        $product->name = $request->input(Attributes::NAME);
        $product->description = $request->input(Attributes::DESCRIPTION);
        $product->quantity = $request->input(Attributes::QUANTITY);
        $product->category_id = $request->input(Attributes::CATEGORY_ID);
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
