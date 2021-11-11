<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
                    'sort_by' => [ 'nullable', Rule::in( [ 'id', 'name' ] ) ],
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
                    'name' => 'required|string|unique:App\Models\State,name|min:3|max:191',
                    'status' => 'required|numeric|boolean',
                    'country_id' => 'required|exists:App\Models\Country,id',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|unique:App\Models\State,name,' . $this->route()->state->id . '|min:3|max:191',
                    'status' => 'required|numeric|boolean',
                    'country_id' => 'required|exists:App\Models\Country,id',
                ];
            }
            default:
                break;
        }
    }
}
