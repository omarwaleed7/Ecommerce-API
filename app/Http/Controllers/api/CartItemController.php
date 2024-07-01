<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\CartItemsRequests\StoreCartItemRequest;
use App\Models\CartItem;
use App\Repositories\CartItemRepository;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    protected BaseServiceInterface $baseService;

    protected BaseRepositoryInterface $baseRepository;

    protected CartItemRepository $cartItemRepository;

    public function __construct(BaseServiceInterface $baseService, BaseRepositoryInterface $baseRepository, CartItemRepository $cartItemRepository)
    {
        $this->baseService=$baseService;
        $this->baseRepository=$baseRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * Get all cart items.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $failureMessage = 'Cart items not found';
        $successMessage = 'Cart items retrieved successfully';

        $data = $this->baseRepository->getAll(CartItem::class);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Get a cart item instance.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Cart item not found';
        $successMessage = 'Cart item retrieved successfully';

        $data = $this->baseRepository->get(CartItem::class,$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Store a newly created cart item.
     *
     * @param StoreCartItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreCartItemRequest $request):JsonResponse
    {
        $successMessage = 'Cart item created successfully';

        $cartItem = CartItem::where('product_id', $request->input('product_id'))
            ->where('user_id', auth()->id())
            ->first();

        if ($cartItem) {
            $this->cartItemRepository->increment($cartItem->id);
            return $this->baseService->apiResponse($cartItem, 'Cart item quantity incremented successfully', 200);
        }

        $cartItem = [
            'product_id' => $request->input('product_id'),
            'user_id' => auth()->user()->getAuthIdentifier()
        ];

        $data = $this->baseRepository->create('App\Models\CartItem',$cartItem);

        return $this->baseService->apiResponse($data,$successMessage,201);
    }

    /**
     * Remove the specified cart item.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $failureMessage = 'Cart item not found';
        $successMessage = 'Cart item deleted successfully';

        $deleteCartItem = $this->baseRepository->delete('App\Models\CartItem',$id);

        if (!$deleteCartItem) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse(null, $successMessage, 200);
    }

    /**
     * Increase the quantity of a specific cart item
     *
     * @param int $id
     * @return JsonResponse
     */
    public function increment(int $id): JsonResponse
    {
        $failureMessage = 'Cart item quantity not found';
        $successMessage = 'Cart item quantity incremented successfully';

        return $this->cartItemRepository->increment($id,$failureMessage,$successMessage);
    }
}
