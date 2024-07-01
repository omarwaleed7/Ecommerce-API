<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\ProductRequests\StoreProductRequest;
use App\Http\Requests\api\ProductRequests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
class ProductController extends Controller
{
    protected BaseServiceInterface $baseService;
    protected BaseRepositoryInterface $baseRepository;

    public function __construct(
        BaseServiceInterface $baseService,
        BaseRepositoryInterface $baseRepository,
    ) {
        $this->baseService = $baseService;
        $this->baseRepository=$baseRepository;
    }

    /**
     * Get all products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $failureMessage = 'Products not found';
        $successMessage = 'Products retrieved successfully';

        $data = $this->baseRepository->getAllPaginated('App\Models\Product', 30);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Display the specified product.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Product not found';
        $successMessage = 'Product retrieved successfully';

        $data = $this->baseRepository->get('App\Models\Product',$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Store a newly created product.
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $successMessage = 'Product created successfully';

        $product = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'manufacture_date' => $request->input('manufacture_date'),
            'expiry_date' => $request->input('expiry_date'),
            'main_img' => $this->baseService->addPic($request, 'main_img', 'product_main_img'),
            'user_id' => auth()->user()->getAuthIdentifier(),
            'category_id' => $request->input('category_id')
        ];

        $data = $this->baseRepository->create('App\Models\Product',$product);
        return $this->baseService->apiResponse($data,$successMessage,201);
    }

    /**
     * Update the specified product.
     * @param UpdateProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $failureMessage = 'Product not found';
        $successMessage = 'Product updated successfully';

        $product = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'manufacture_date' => $request->input('manufacture_date'),
            'expiry_date' => $request->input('expiry_date'),
            'main_img' => $this->baseService->addPic($request, 'main_img', 'product_img')
        ];

        $data = $this->baseRepository->update($id,'App\Models\Product',$product);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Remove the specified product.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $failureMessage = 'Product not found';
        $successMessage = 'Product deleted successfully';

        $deletedProduct = $this->baseRepository->delete('App\Models\Product',$id);

        if (!$deletedProduct) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse(null,$successMessage,200);
    }

}
