<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;

interface IProductService
{
    public function createProduct(StoreProductRequest $request);
    public function getAllProducts();
    public function getProductById($id);
    public function updateProduct(UpdateProductRequest $request, $id);
    public function deleteProduct($id);
}
