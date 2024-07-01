<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface BaseServiceInterface
{
    /**
     * generate an API response.
     * @param $data
     * @param $message
     * @param $status
     * @return JsonResponse
     */
    public function apiResponse($data, $message, $status): JsonResponse;

    /**
     * Add a picture to the storage.
     *
     * @param Request $request
     * @param string $file_name
     * @param string $disk
     * @param string|null $folder
     * @return string
     */
    public function addPic(Request $request, string $file_name, string $disk, string $folder = null): string;
}
