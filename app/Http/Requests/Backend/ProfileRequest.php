<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|unique:App\Models\User,username,'.auth()->id().'|min:3|max:191',
            'first_name' => 'required|string|min:3|max:191',
            'last_name' => 'required|string|min:3|max:191',
            'email' => 'required|email|unique:App\Models\User,email,'.auth()->id().'',
            'phone' => 'required|string|unique:App\Models\User,phone,'.auth()->id().'',
            'password' => 'nullable|string|confirmed|min:6',
            'user_image' => 'nullable|mimes:jpg,jpeg,png|max:2000',
        ];
    }

}
