<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
                    'sort_by' => [ 'nullable', Rule::in( [ 'id', 'name', 'code', 'created_at' ] ) ],
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
                    'name' => 'required|min:3|max:191',
                    'code' => 'required|string|unique:App\Models\PaymentMethod,code|min:3|max:191',
                    'driver_name' => 'nullable|string|unique:App\Models\PaymentMethod,driver_name|min:3|max:191',
                    'merchant_email' => 'nullable|email',
                    'username' => 'nullable',
                    'password' => 'nullable',
                    'secret' => 'nullable',
                    'sandbox_username' => 'nullable',
                    'sandbox_password' => 'nullable',
                    'sandbox_secret' => 'nullable',
                    'sandbox' => 'nullable',
                    'status' => 'required|numeric|boolean',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|min:3|max:191',
                    'code' => 'required|string|unique:App\Models\PaymentMethod,code,' . $this->route()->payment_method->id . '|min:3|max:191',
                    'driver_name' => 'nullable|string|unique:App\Models\PaymentMethod,driver_name,' . $this->route()->payment_method->id . '|min:3|max:191',
                    'merchant_email' => 'nullable|email',
                    'username' => 'nullable',
                    'password' => 'nullable',
                    'secret' => 'nullable',
                    'sandbox_username' => 'nullable',
                    'sandbox_password' => 'nullable',
                    'sandbox_secret' => 'nullable',
                    'sandbox' => 'nullable',
                    'status' => 'required|numeric|boolean',
                ];
            }
            default:
                break;
        }
    }

}
