<?php

namespace App\Http\Requests\api\WishlistItemRequest;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreWishlistItemFormRequest extends BaseFormRequest
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
            'product_id'=>[
                'required',
                'exists:products,id',
                Rule::unique('wishlist_items','product_id')->where('user_id',auth()->user()->getAuthIdentifier())
            ]
        ];
    }
}
