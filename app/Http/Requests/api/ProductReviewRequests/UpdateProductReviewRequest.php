<?php

namespace App\Http\Requests\api\ProductReviewRequests;

use App\Http\Requests\BaseFormRequest;

class UpdateProductReviewRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'feedback' => 'required|string',
            'rate' => 'required|integer|between:1,5',
        ];
    }
}
