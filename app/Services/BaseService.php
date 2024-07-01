<?php

namespace App\Services;

use App\Contracts\BaseServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BaseService implements BaseServiceInterface
{
    /**
     * Generate a JSON response.
     *
     * @param  mixed|null  $data
     * @param  string|null  $message
     * @param  int|null  $status
     * @return JsonResponse
     */
    public function apiResponse($data = null, $message = null, $status = null): JsonResponse
    {
        $array = [
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ];
        return new JsonResponse($array, $status);
    }

    /**
     * Add a picture to the storage.
     *
     * @param  Request  $request
     * @param string $file_name
     * @param string $disk
     * @param string|null $folder
     * @return string
     */
    public function addPic(Request $request, string $file_name, string $disk, string $folder = null): string
    {
        $image = Str::uuid() . '_' . $request->file($file_name)->getClientOriginalName();

        if ($folder == null) {
            $path = $request->file($file_name)->storeAs($disk, $image);
        } else {
            $path = $request->file($file_name)->storeAs($disk, $image, $folder);
        }

        return $path;
    }
}
