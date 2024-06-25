<?php

namespace App\Services\Interfaces;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

interface ICategoryService
{
    public function createCategory(StoreCategoryRequest $request): array|object;
    public function getAllCategories();
    public function getCategoryById(int $id) : array|object;
    public function updateCategory(Request $request, int $id) : array|object;
    public function deleteCategory(int $id) : array|object;
    public function countProducts(int|string $identifier) : array|object;
}
