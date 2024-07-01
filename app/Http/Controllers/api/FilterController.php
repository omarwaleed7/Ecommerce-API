<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseServiceInterface;
use App\Http\Requests\FilterRequests\FilterByPriceRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class FilterController
{
    protected BaseServiceInterface $baseService;
    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Filter products by price.
     *
     * @param FilterByPriceRequest $request
     * @return JsonResponse
     */
    public function filterByPrice(FilterByPriceRequest $request): JsonResponse
    {
        $failureMessage = 'Products not found';
        $successMessage = 'Products retrieved successfully';

        $products = Product::whereBetween('price',[$request->input('min_price'),$request->input('max_price')])->get();

        if ($products->isEmpty()) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($products, $successMessage, 200);
    }

    /**
     * Filter products by category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function filterByCategory(int $id): JsonResponse
    {
        $failureMessage = 'Products not found';
        $successMessage = 'Products retrieved successfully';

        $products = Product::where('category_id',$id)->get();

        if ($products->isEmpty()) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($products, $successMessage, 200);
    }
}
