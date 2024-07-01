<?php

namespace App\Http\Requests\api\ProductReviewRequests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreProductReviewRequest extends BaseFormRequest
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
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('product_reviews', 'product_id')->where('user_id', auth()->user()->getAuthIdentifier()),

                // Check if the user has ordered the product
                Rule::exists('orders')->where(function ($query) {
                    $query->where('user_id', auth()->user()->getAuthIdentifier())
                        ->whereHas('orderItems', function ($query) {
                            $query->where('product_id', request()->input('product_id'));
                        });
                }),
            ],
        ];
    }
}
