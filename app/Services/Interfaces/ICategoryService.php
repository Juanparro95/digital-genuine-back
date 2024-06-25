<?php

namespace App\Services\Interfaces;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

interface ICategoryService
{
    public function createCategory(StoreCategoryRequest $request): array|object;
    public function getAllCategories();
    public function getCategoryById(int $id) : array|object;
    public function updateCategory(UpdateCategoryRequest $request, int $id) : array|object;
    public function deleteCategory(int $id) : array|object;
    public function countProducts(int|string $identifier) : array|object;
}
