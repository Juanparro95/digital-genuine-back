<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Interfaces\ICategoryService;

class CategoryService implements ICategoryService
{
    protected mixed $modelClass;

    public function __construct()
    {
        $this->modelClass = new Category;
    }
    
    public function createCategory(StoreCategoryRequest $request): array|object
    {
        $this->modelClass->name = $request->input('name');
        $this->modelClass->description = $request->input('description');
        $this->modelClass->save();

        return $this->modelClass;
    }

    public function getAllCategories()
    {
        return $this->modelClass::all();
    }

    public function getCategoryById(int $id): array|object
    {
        return $this->modelClass::findOrFail($id);
    }

    public function updateCategory(UpdateCategoryRequest $request, int $id): array|object
    {
        $category = $this->modelClass::findOrFail($id);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return $category;
    }

    public function deleteCategory(int $id): array|object
    {
        $category = $this->modelClass::findOrFail($id);
        $category->delete();

        return $category;
    }

    public function countProducts(int|string $identifier) : array|object
    {
        if (is_numeric($identifier)) {
            $category = $this->modelClass::findOrFail($identifier);
        } else {
            $category = $this->modelClass::where('name', $identifier)->firstOrFail();
        }

        $productCount = Product::where('category_id', $category->id)->count();

        return [
            'category' => $category->name,
            'product_count' => $productCount
        ];
    }

}
