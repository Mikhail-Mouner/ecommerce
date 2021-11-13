<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingCompanyRequest extends FormRequest
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
                    'sort_by' => [ 'nullable', Rule::in( [ 'id', 'name', 'created_at' ] ) ],
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
                    'name' => 'required|string',
                    'code' => 'required|string|unique:App\Models\ShippingCompany,code',
                    'description' => 'required|string',
                    'cost' => 'required|numeric',
                    'status' => 'required|numeric|boolean',
                    'fast' => 'required|numeric|boolean',
                    'country_id' => 'required',
                    'country_id.*' => 'required|exists:App\Models\Country,id',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string',
                    'code' => 'required|string|unique:App\Models\ShippingCompany,code,' . $this->route()->shipping_company->id,
                    'description' => 'required|string',
                    'cost' => 'required|numeric',
                    'status' => 'required|numeric|boolean',
                    'fast' => 'required|numeric|boolean',
                    'country_id' => 'required',
                    'country_id.*' => 'required|exists:App\Models\Country,id',
                ];
            }
            default:
                break;
        }
    }

}
