<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterAndSortRequests\FilterAndSortRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class FilterAndSortController extends Controller
{
    protected BaseServiceInterface $baseService;

    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Filter and sort products.
     *
     * @param FilterAndSortRequest $request
     * @return JsonResponse
     */
    public function filterAndSort(FilterAndSortRequest $request): JsonResponse
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $categoryId = $request->input('category_id');
        $sortBy = $request->input('sort_by');

        $query = Product::query();

        if ($minPrice !== null && $maxPrice !== null) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }
        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        if ($sortBy !== null) {
            switch ($sortBy) {
                case 'name':
                    $query->orderBy('name');
                    break;
                case 'price':
                    $query->orderBy('price');
                    break;
                case 'price_desc':
                    $query->orderByDesc('price');
                    break;
                case 'date':
                    $query->orderBy('manufacture_date');
                    break;
            }
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }
}
