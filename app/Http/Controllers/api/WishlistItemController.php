<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\WishlistItemRequest\StoreWishlistItemFormRequest;
use Illuminate\Http\JsonResponse;



class WishlistItemController extends Controller
{
    protected BaseServiceInterface $baseService;
    protected BaseRepositoryInterface $baseRepository;

    public function __construct(BaseServiceInterface $baseService, BaseRepositoryInterface $baseRepository)
    {
        $this->baseService = $baseService;
        $this->baseRepository = $baseRepository;
    }

    /**
     * Get all wishlist items.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $failureMessage = 'Wishlist items not found';
        $successMessage = 'Wishlists items retrieved successfully';

        $data = $this->baseRepository->getAll('App\Models\WishlistItem');

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);

    }

    /**
     * Get a wishlist item instance.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Wishlist item not found';
        $successMessage = 'Wishlist item retrieved successfully';

        $data = $this->baseRepository->get('App\Models\WishlistItem',$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data, $successMessage, 200);
    }

    /**
     * Store a newly created wishlist.
     *
     * @param StoreWishlistItemFormRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistItemFormRequest $request): JsonResponse
    {
        $successMessage = 'Wishlist item created successfully';

        $wishlistItem = [
            'user_id' => auth()->user()->getAuthIdentifier(),
            'product_id' => $request->input('product_id')
        ];

        $data = $this->baseRepository->create('App\Models\WishlistItem',$wishlistItem);

        return $this->baseService->apiResponse($data,$successMessage,201);
    }

    /**
     * Remove the specified wishlist.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $failureMessage = 'Wishlist item not found';
        $successMessage = 'Wishlist item deleted successfully';

        $deleteVoucher = $this->baseRepository->delete('App\Models\WishlistItem',$id);

        if (!$deleteVoucher) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse(null, $successMessage, 200);
    }
}
