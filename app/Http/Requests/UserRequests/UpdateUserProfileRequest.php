<?php

namespace App\Http\Requests\UserRequests;

use App\Http\Requests\BaseFormRequest;

class UpdateUserProfileRequest extends BaseFormRequest
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
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.auth()->id,
            'password'=>'required|string|confirmed',
            'profile_picture'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'phone_number' => 'required|regex:/^\+?\d{1,3}?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/',
        ];
    }
}
