<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCouponRequest extends FormRequest
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
                    'sort_by' => [ 'nullable', Rule::in( [ 'id', 'code', 'created_at' ] ) ],
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
                    'code' => 'required|string|unique:App\Models\ProductCoupon,code|min:3|max:191',
                    'type' => [ 'required', Rule::in( [ 'fixed', 'percentage' ] ) ],
                    'status' => 'required|numeric|boolean',
                    'value' => 'required|string',
                    'desc' => 'nullable|string',
                    'use_times' => 'required|numeric|min:1',
                    'start_date' => 'required|date|before_or_equal:expire_date',
                    'expire_date' => 'required|date|after_or_equal:start_date',
                    'greater_than' => 'nullable|numeric',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'code' => 'required|string|unique:App\Models\ProductCoupon,code,' . $this->route()->product_coupon->id . '|min:3|max:191',
                    'type' => [ 'required', Rule::in( [ 'fixed', 'percentage' ] ) ],
                    'status' => 'required|numeric|boolean',
                    'value' => 'required|string',
                    'desc' => 'nullable|string',
                    'use_times' => 'required|numeric|min:1',
                    'start_date' => 'required|date|before_or_equal:expire_date',
                    'expire_date' => 'required|date|after_or_equal:start_date',
                    'greater_than' => 'nullable|numeric',
                ];
            }
            default:
                break;
        }
    }

}
