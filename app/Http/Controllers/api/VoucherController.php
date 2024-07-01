<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\VoucherRequests\VoucherRequest;
use Illuminate\Http\JsonResponse;

class VoucherController extends Controller
{
    protected BaseServiceInterface $baseService;
    protected BaseRepositoryInterface $baseRepository;
    public function __construct(
        BaseServiceInterface $baseService,
        BaseRepositoryInterface $baseRepository
    ) {
        $this->baseService=$baseService;
        $this->baseRepository=$baseRepository;
    }

    /**
     * Get all vouchers.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $failureMessage = 'Vouchers not found';
        $successMessage = 'Vouchers retrieved successfully';

        $data = $this->baseRepository->getAllPaginated('App\Models\Voucher', 100);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data, $successMessage, 200);    }

    /**
     * Get a voucher instance.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Voucher not found';
        $successMessage = 'Voucher retrieved successfully';

        $data = $this->baseRepository->get('App\Models\Voucher',$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Store a newly created voucher.
     *
     * @param VoucherRequest $request
     * @return JsonResponse
     */
    public function store(VoucherRequest $request): JsonResponse
    {
        $successMessage = 'Category created successfully';

        $voucher = [
            'name'=>$request->input('name'),
            'value'=>$request->input('value'),
            'user_id'=>auth()->user()->getAuthIdentifier()
        ];

        $data = $this->baseRepository->create('App\Models\Voucher',$voucher);

        return $this->baseService->apiResponse($data,$successMessage,201);
    }

    /**
     * Update the specified voucher.
     *
     * @param VoucherRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(VoucherRequest $request,int $id): JsonResponse
    {
        $failureMessage = 'Voucher not found';
        $successMessage = 'Voucher updated successfully';

        $voucher = [
            'name'=>$request->input('name'),
            'value'=>$request->input('value'),
        ];

        $data = $this->baseRepository->update($id,'App\Models\Voucher',$voucher);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Remove the specified voucher.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $failureMessage = 'Voucher not found';
        $successMessage = 'Voucher deleted successfully';

        $deleteVoucher = $this->baseRepository->delete('App\Models\Voucher',$id);

        if (!$deleteVoucher) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse(null, $successMessage, 200);
    }
}
