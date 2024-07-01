<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseServiceInterface;
use App\Http\Requests\SearchRequests\SearchRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class SearchController
{
    protected BaseServiceInterface $baseService;

    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Search for products.
     *
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function search(SearchRequest $request): JsonResponse
    {
        $searchQuery = $request->input('search_query');

        $products = Product::where('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('description', 'like', '%' . $searchQuery . '%')
            ->get();

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        // Return the success response with the searched products
        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }

}
