<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICategoryService;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class WebhookController extends Controller
{
    protected ICategoryService $i_CategoryServices;

    public function __construct(ICategoryService $i_CategoryServices)
    {
        $this->i_CategoryServices = $i_CategoryServices;
    }

    #[OA\Get(
        path: "/api/v1/webhook/{identifier}/count-products",
        summary: "Count products in a category for webhook",
        tags: ["Webhook"],
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
                    mediaType: "application/json"
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
