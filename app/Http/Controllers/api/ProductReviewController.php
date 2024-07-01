<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\ProductReviewRequests\StoreProductReviewRequest;
use App\Models\ProductReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductReviewController extends Controller
{
    protected BaseServiceInterface $baseService;
    protected BaseRepositoryInterface $baseRepository;

    public function __construct(BaseServiceInterface $baseService, BaseRepositoryInterface $baseRepository)
    {
        $this->baseService = $baseService;
        $this->baseRepository = $baseRepository;
    }

    /**
     * Get all product reviews for a specific product.
     *
     * @param int $product_id
     * @return JsonResponse
     */
    public function index(int $product_id): JsonResponse
    {
        $failureMessage = 'Product reviews not found';
        $successMessage = 'Product reviews retrieved successfully';

        // Query ProductReview where product_id matches the given $product_id
        $productReviews = ProductReview::where('product_id', $product_id)->get();

        if ($productReviews->isEmpty()) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($productReviews, $successMessage, 200);
    }


    /**
     * Get a product review instance.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Product review not found';
        $successMessage = 'Product review retrieved successfully';

        $data = $this->baseRepository->get('App\Models\ProductReview',$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Store a newly created product review.
     *
     * @param StoreProductReviewRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductReviewRequest $request): JsonResponse
    {
        $successMessage = 'Product review created successfully';

        $productReview = [
            'user_id' => auth()->user()->getAuthIdentifier(),
            'product_id' => $request->input('product_id'),
            'feedback' => $request->input('feedback'),
            'rate' => $request->input('rate'),
        ];

        $data = $this->baseRepository->create('App\Models\ProductReview', $productReview);

        return $this->baseService->apiResponse($data,$successMessage,201);
    }

    /**
     * Update the specified product review.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $failureMessage = 'Product review not found';
        $successMessage = 'Product review updated successfully';

        $productReview = [
            'feedback' => $request->input('feedback'),
            'rate' => $request->input('rate'),
        ];

        $data = $this->baseRepository->update($id, 'App\Models\ProductReview', $productReview);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Remove the specified product review.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $failureMessage = 'Product review not found';
        $successMessage = 'Product review deleted successfully';

        $deletedProductReview = $this->baseRepository->delete('App\Models\ProductReview', $id);

        if (!$deletedProductReview) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse(null,$successMessage,200);
    }
}
