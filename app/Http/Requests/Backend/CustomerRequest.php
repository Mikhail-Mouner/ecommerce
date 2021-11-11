<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            {
                return [
                    'keyword' => 'nullable|string',
                    'status' => 'nullable|numeric|boolean',
                    'sort_by' => [ 'nullable', Rule::in( [ 'id', 'first_name', 'last_name', 'created_at' ] ) ],
                    'order_by' => [ 'nullable', Rule::in( [ 'asc', 'desc' ] ) ],
                    'limit_by' => 'nullable|numeric',
                ];
            }
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'username' => 'required|string|unique:App\Models\User,username|min:3|max:191',
                    'first_name' => 'required|string|min:3|max:191',
                    'last_name' => 'required|string|min:3|max:191',
                    'email' => 'required|email|unique:App\Models\User,email',
                    'phone' => 'required|string|unique:App\Models\User,phone',
                    'status' => 'required|numeric|boolean',
                    'password' => 'required|string|confirmed|min:6',
                    'user_image' => 'nullable|mimes:jpg,jpeg,png|max:2000',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'username' => 'required|string|unique:App\Models\User,username,' . $this->route()->customer->id . '|min:3|max:191',
                    'first_name' => 'required|string|min:3|max:191',
                    'last_name' => 'required|string|min:3|max:191',
                    'email' => 'required|email|unique:App\Models\User,email,' . $this->route()->customer->id,
                    'phone' => 'required|string|unique:App\Models\User,phone,' . $this->route()->customer->id,
                    'status' => 'required|numeric|boolean',
                    'password' => 'nullable|string|confirmed|min:6',
                    'user_image' => 'nullable|mimes:jpg,jpeg,png|max:2000',
                ];
            }
            default:
                break;
        }
    }

}
