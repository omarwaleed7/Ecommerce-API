<?php

namespace App\Http\Requests\FilterAndSortRequests;

use App\Http\Requests\BaseFormRequest;

class FilterAndSortRequest extends BaseFormRequest
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
                'min_price' => 'numeric|min:0',
                'max_price' => 'numeric|min:0|gte:min_price',
                'category_id' => 'nullable|exists:categories,id',
                'sort_by' => 'nullable|in:name,price,price_desc,date,popularity',
        ];
    }
}
