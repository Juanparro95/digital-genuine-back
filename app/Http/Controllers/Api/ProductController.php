<?php

namespace App\Http\Controllers\Api;

use App\Enums\Attributes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{

    const ROUTE_API = '/api/v1/products';
    protected IProductService $iProductService;

    public function __construct(IProductService $productService)
    {
        $this->iProductService = $productService;
    }

    #[OA\Post(
        path: self::ROUTE_API,
        summary: "Create a new product",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: [Attributes::NAME, Attributes::QUANTITY, Attributes::CATEGORY_ID],
                    properties: [
                        new OA\Property(property: Attributes::NAME, description: "Product name", type: "string"),
                        new OA\Property(property: Attributes::DESCRIPTION, description: "Product description", type: "string"),
                        new OA\Property(property: Attributes::QUANTITY, description: "Product quantity", type: "integer"),
                        new OA\Property(property: Attributes::CATEGORY_ID, description: "Category ID", type: "integer"),
                    ]
                )
            )
        ),
        tags: ["Products"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Product created successfully",
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
            ),
            new OA\Response(
                response: 500,
                description: "Internal Server Error",
                content: new OA\MediaType(
                    mediaType: "application/json"
                )
            ),
        ]
    )]
    public function store(StoreProductRequest $request)
    {
        $product = $this->iProductService->createProduct($request);
        return response()->json($product, Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: self::ROUTE_API,
        summary: "Get all products",
        tags: ["Products"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\MediaType(
                    mediaType: "application/json"
                )
            )
        ]
    )]
    public function index()
    {
        $products = $this->iProductService->getAllProducts();
        return response()->json($products, Response::HTTP_OK);
    }

    #[OA\Get(
        path: self::ROUTE_API."/{id}",
        summary: "Get a product by ID",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(name: Attributes::_ID, in: "path", required: true, schema: new OA\Schema(type: "integer"))
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
                    mediaType: "application/json"
                )
            )
        ]
    )]
    public function show($id)
    {
        try {
            $product = $this->iProductService->getProductById($id);
            return response()->json($product, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Put(
        path: self::ROUTE_API."/{id}",
        summary: "Update a product",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: [Attributes::NAME, Attributes::QUANTITY, Attributes::CATEGORY_ID],
                    properties: [
                        new OA\Property(property: Attributes::NAME, description: "Product name", type: "string"),
                        new OA\Property(property: Attributes::DESCRIPTION, description: "Product description", type: "string"),
                        new OA\Property(property: Attributes::QUANTITY, description: "Product quantity", type: "integer"),
                        new OA\Property(property: Attributes::CATEGORY_ID, description: "Category ID", type: "integer"),
                    ]
                )
            )
        ),
        tags: ["Products"],
        parameters: [
            new OA\Parameter(name: Attributes::_ID, in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
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
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = $this->iProductService->updateProduct($request, $id);
            return response()->json($product, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Delete(
        path: self::ROUTE_API."/{id}",
        summary: "Delete a product",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(name: Attributes::_ID, in: "path", required: true, schema: new OA\Schema(type: "integer"))
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
            )
        ]
    )]
    public function destroy($id)
    {
        try {
            $this->iProductService->deleteProduct($id);
            return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
