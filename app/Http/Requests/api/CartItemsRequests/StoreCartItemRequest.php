<?php

namespace App\Http\Requests\api\CartItemsRequests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreCartItemRequest extends BaseFormRequest
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
            'product_id' => [
                'required',
                'exists:products,id',
            ]
        ];
    }
}
