<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerAddressRequest extends FormRequest
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
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'user_id' => 'required|exists:App\Models\User,id',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'mobile' => 'required|numeric',
                    'address' => 'required',
                    'address2' => 'nullable',
                    'country_id' => 'required|exists:App\Models\Country,id',
                    'state_id' => 'required|exists:App\Models\State,id',
                    'city_id' => 'required|exists:App\Models\City,id',
                    'address_title' => 'required',
                    'default_address' => 'required|numeric|boolean',
                    'zip_code' => 'required',
                    'po_box' => 'required',
                ];
            }
            default:
                break;
        }
    }

}
