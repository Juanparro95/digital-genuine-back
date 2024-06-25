<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    const ROUTE_API = '/api/v1/categories';

    protected ICategoryService $i_CategoryServices;

    public function __construct(ICategoryService $iCategoryServices)
    {
        $this->i_CategoryServices = $iCategoryServices;
    }

    #[OA\Post(
        path: self::ROUTE_API,
        summary: "Create a new category",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["name"],
                    properties: [
                        new OA\Property(property: 'name', description: "Category name", type: "string"),
                        new OA\Property(property: 'description', description: "Category description", type: "string"),
                    ]
                )
            )
        ),
        tags: ["Categories"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Category created successfully",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'id', description: "Category ID", type: "integer"),
                            new OA\Property(property: 'name', description: "Category name", type: "string"),
                            new OA\Property(property: 'description', description: "Category description", type: "string"),
                            new OA\Property(property: 'created_at', description: "Creation timestamp", type: "string", format: "date-time"),
                            new OA\Property(property: 'updated_at', description: "Update timestamp", type: "string", format: "date-time"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation Error",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'message', description: "Validation error message", type: "string"),
                            new OA\Property(property: 'errors', description: "Validation errors details", type: "object"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 500,
                description: "Internal Server Error",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'error', description: "Error message", type: "string"),
                        ]
                    )
                )
            ),
        ]
    )]
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->i_CategoryServices->createCategory($request);
            return response()->json($category, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the category.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[OA\Get(
        path: self::ROUTE_API,
        summary: "Get all categories",
        tags: ["Categories"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function index()
    {
        return response()->json($this->i_CategoryServices->getAllCategories(), Response::HTTP_OK);
    }

    #[OA\Get(
        path: self::ROUTE_API."/{id}",
        summary: "Get a category by ID",
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\MediaType(
                    mediaType: "application/json",
                )
            ),
            new OA\Response(
                response: 404,
                description: "Not Found",
                content: new OA\MediaType(
                    mediaType: "application/json",
                )
            )
        ]
    )]
    public function show($id)
    {
        try {
            $category = $this->i_CategoryServices->getCategoryById($id);
            return response()->json($category, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Put(
        path: self::ROUTE_API."/{id}",
        summary: "Update a category",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["name"],
                    properties: [
                        new OA\Property(property: 'name', description: "Category name", type: "string"),
                        new OA\Property(property: 'description', description: "Category description", type: "string"),
                    ]
                )
            )
        ),
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\MediaType(
                    mediaType: "application/json"
                )
            ),
            new OA\Response(
                response: 404,
                description: "Not Found",
                content: new OA\MediaType(
                    mediaType: "application/json"
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation Error",
                content: new OA\MediaType(
                    mediaType: "application/json"
                )
            )
        ]
    )]
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->i_CategoryServices->updateCategory($request, $id);
            return response()->json($category, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Delete(
        path: self::ROUTE_API."/{id}",
        summary: "Delete a category",
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'message', description: "Success message", type: "string"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: "Not Found",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'message', description: "Not Found error message", type: "string"),
                        ]
                    )
                )
            )
        ]
    )]
    public function destroy($id)
    {
        try {
            $this->i_CategoryServices->deleteCategory($id);
            return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Get(
        path: self::ROUTE_API."/{identifier}/count-products",
        summary: "Count products in a category",
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(name: "identifier", in: "path", required: true, schema: new OA\Schema(type: "string", description: "Category ID or name"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'category', description: "Category name", type: "string"),
                            new OA\Property(property: 'product_count', description: "Number of products in the category", type: "integer"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: "Not Found",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'message', description: "Not Found error message", type: "string"),
                        ]
                    )
                )
            )
        ]
    )]
    public function countProducts($identifier)
    {
        try {
            $result = $this->i_CategoryServices->countProducts($identifier);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
