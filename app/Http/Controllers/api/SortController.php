<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SortController extends Controller
{
    protected BaseServiceInterface $baseService;
    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Sort products by name.
     *
     * @return JsonResponse
     */
    public function sortByName(): JsonResponse
    {
        $products = Cache::rememberForever('sorted_products_by_name', function () {
            return Product::orderBy('name')->get();
        });

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        // Return the success response with the sorted products
        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }

    /**
     * Sort products by price
     *
     * @return JsonResponse
     */
    public function sortByPrice(): JsonResponse
    {
        $products = Cache::rememberForever('sorted_products_by_price', function () {
            return Product::orderBy('price')->get();
        });

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }

    /**
     * Sort product by price descending
     *
     * @returns JsonResponse
     */
    public function sortByPriceDesc(): JsonResponse
    {
        $products = Cache::rememberForever('sorted_products_by_price_desc', function () {
            // Execute the database query to sort products by name
            return Product::orderBy('price','desc')->get();
        });

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }

    /**
     * Sort products by manufacture date
     *
     * @returns JsonResponse
     */
    public function sortByDate(): JsonResponse
    {
        $products = Cache::rememberForever('sorted_products_by_price', function () {
            return Product::orderBy('manufacture_date')->get();
        });

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }


    /**
     * Sort products by manufacture date descending
     *
     * @returns JsonResponse
     */
    public function sortByDateDesc(): JsonResponse
    {
        $products = Cache::rememberForever('sorted_products_by_price', function () {
            return Product::orderBy('manufacture_date','desc')->get();
        });

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }

    /**
     * Sort Products by popularity (number of orders)
     *
     * @return JsonResponse
     */
    public function sortByPopularity(): JsonResponse
    {
        $products = Cache::rememberForever('sorted_products_by_popularity', function () {
            return Product::select('products.*', DB::raw('COUNT(order_items.cart_item_id) as order_count'))
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->orderByDesc('order_count')
                ->get();
        });

        if ($products->isEmpty()) {
            $failureMessage = 'Products not found';
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        $successMessage = 'Products retrieved successfully';
        return $this->baseService->apiResponse($products, $successMessage, 200);
    }
}
