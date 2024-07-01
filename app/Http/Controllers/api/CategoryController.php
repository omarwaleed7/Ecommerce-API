<?php

namespace App\Http\Controllers\api;
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\CategoryRequests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    protected BaseServiceInterface $baseService;
    protected BaseRepositoryInterface $baseRepository;

    public function __construct(
        BaseServiceInterface $baseService,
        BaseRepositoryInterface $baseRepository
    ) {
        $this->baseService = $baseService;
        $this->baseRepository=$baseRepository;
    }

    /**
     * Get all categories.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $failureMessage = 'Categories not found';
        $successMessage = 'Categories retrieved successfully';

        $data = $this->baseRepository->getAllPaginated('App\Models\Category', 100);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data, $successMessage, 200);
    }

    /**
     * Get a category instance.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $failureMessage = 'Category not found';
        $successMessage = 'Category retrieved successfully';

        $data = $this->baseRepository->get('App\Models\Category',$id);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Store a newly created category.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $successMessage = 'Category created successfully';

        $category = [
            'name' => $request->input('name'),
            'user_id' => auth()->user()->getAuthIdentifier(),
        ];

        $data = $this->baseRepository->create('App\Models\Category',$category);

        return $this->baseService->apiResponse($data,$successMessage,201);
    }

    /**
     * Update the specified category.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $id): JsonResponse
    {
        $failureMessage = 'Category not found';
        $successMessage = 'Category updated successfully';

        $category = [
            'name' => $request->input('name'),
        ];

        $data = $this->baseRepository->update($id,'App\Models\Category',$category);

        if ($data == null) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse($data,$successMessage,200);
    }

    /**
     * Remove the specified category.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $failureMessage = 'Category not found';
        $successMessage = 'Category deleted successfully';

        $deleteCategory = $this->baseRepository->delete('App\Models\Category',$id);

        if (!$deleteCategory) {
            return $this->baseService->apiResponse(null, $failureMessage, 404);
        }

        return $this->baseService->apiResponse(null, $successMessage, 200);
    }
}
