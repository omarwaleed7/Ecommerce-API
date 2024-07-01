<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\OrderRequests\StoreOrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Voucher;
use App\Repositories\OrderItemRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected BaseServiceInterface $baseService;

    protected BaseRepositoryInterface $baseRepository;

    protected OrderItemRepository $orderItemRepository;
    public function __construct(BaseServiceInterface $baseService,BaseRepositoryInterface $baseRepository,OrderItemRepository $orderItemRepository){
        $this->baseService=$baseService;
        $this->baseRepository=$baseRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * Get all orders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $failureMessage = 'Orders not found';
        $successMessage = 'Orders retrieved successfully';

        $data = $this->baseRepository->getAll('App\Models\Order');

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Get an order instance.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Order not found';
        $successMessage = 'Order retrieved successfully';

        $data = $this->baseRepository->get('App\Models\Order',$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Store a newly created order.
     *
     * @param StoreOrderRequest $request
     * @return mixed
     */
    public function store(StoreOrderRequest $request): mixed
    {
        $cartItems = CartItem::where('user_id',auth()->user()->getAuthIdentifier())->get();

        $totalPrice = 0;

        foreach ($cartItems as $cartItem){
            $totalPrice += $cartItem->quantity * $cartItem->price;
        }

        if ($request->has('voucher')){
            $voucher = Voucher::where('name', $request->input('voucher'))
                ->select('value')
                ->first();
            if ($voucher) {
                $totalPrice -= $voucher->value;
            }
            else {
                return $this->baseService->apiResponse(null, 'Voucher not found', 404);
            }
        }

        // Create order
        $order = [
            'total_price' => $totalPrice,
            'user_id' => auth()->user()->getAuthIdentifier(),
        ];

        $cartItems->each->delete();

        $data = $this->baseRepository->create('App\Models\Order',$order);

        $order = Order::latest()->select('id')->first();

        $orderID = $order->id;

        $this->orderItemRepository->store($cartItems,$orderID);

        $paymentKey = PaymentController::pay($orderID,$totalPrice);

        return view('paymob')->with('token',$paymentKey);
    }
}
