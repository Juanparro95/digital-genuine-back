<?php

namespace App\Services;

use App\Enums\Attributes;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
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
        $this->modelClass->name = $request->input(Attributes::NAME);
        $this->modelClass->description = $request->input(Attributes::DESCRIPTION);
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
        $category->name = $request->input(Attributes::NAME);
        $category->description = $request->input(Attributes::DESCRIPTION);
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
            $category = $this->modelClass::where(Attributes::NAME, $identifier)->firstOrFail();
        }

        $productCount = Product::where(Attributes::CATEGORY_ID, $category->id)->count();

        return [
            'category' => $category->name,
            'product_count' => $productCount
        ];
    }

}
