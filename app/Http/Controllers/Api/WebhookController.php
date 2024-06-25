<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class WebhookController extends Controller
{
    protected ICategoryService $i_CategoryServices;

    public function __construct(ICategoryService $i_CategoryServices)
    {
        $this->i_CategoryServices = $i_CategoryServices;
    }

    #[OA\Post(
        path: "/api/v1/webhook/count-products",
        summary: "Count products in a category for webhook",
        tags: ["Webhook"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    properties: [
                        new OA\Property(property: 'category', description: "Category ID or name", type: "string")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(property: 'fulfillmentText', description: "Response text", type: "string"),
                            new OA\Property(property: 'fulfillmentMessages', description: "Response messages", type: "array", items: new OA\Items(type: "object"))
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
    public function countProducts(Request $request)
    {
        $category = $request->input('queryResult.parameters.categories');

        try {
            $result = $this->i_CategoryServices->countProducts($category);
            $categoryName = $result['category'];
            $productCount = $result['product_count'];

            $responseText = "In $categoryName, there are $productCount products available.";
            
            return response()->json([
                'fulfillmentText' => $responseText,
                'fulfillmentMessages' => [
                    [
                        'text' => [
                            'text' => [$responseText]
                        ]
                    ]
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'fulfillmentText' => 'Category not found.',
                'fulfillmentMessages' => [
                    [
                        'text' => [
                            'text' => ['Category not found.']
                        ]
                    ]
                ]
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
