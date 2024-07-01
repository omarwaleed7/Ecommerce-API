<?php

namespace App\Http\Requests\api\ProductRequests;

use App\Http\Requests\BaseFormRequest;

class StoreProductRequest extends BaseFormRequest
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
            'name'=>'required|string',
            'price'=>'required|numeric',
            'description'=>'required|string',
            'quantity' => 'required|integer',
            'manufacture_date' => 'required|date',
            'expiry_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'main_img'=>'required|image|mimes:jpeg,png,jpg|max:5120',
        ];
    }
}
