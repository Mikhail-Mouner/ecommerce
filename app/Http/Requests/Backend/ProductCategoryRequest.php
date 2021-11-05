<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCategoryRequest extends FormRequest
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
                    'name' => 'required|string|unique:App\Models\ProductCategory,name|min:3|max:191',
                    'cover' => 'required|mimes:jpg,jpeg,png|max:2000',
                    'status' => 'required|numeric|boolean',
                    'parent_id' => [
                        'sometimes',
                        function ($attribute, $value, $fail) {
                            if ($value !== 'foo') {
                                Rule::exists( 'App\Models\ProductCategory,id' );
                            }

                            return TRUE;
                        },
                    ],
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|unique:App\Models\ProductCategory,name,' . $this->route()->product_category->id . '|min:3|max:191',
                    'cover' => 'sometimes|mimes:jpg,jpeg,png|max:2000',
                    'status' => 'required|numeric|boolean',
                    'parent_id' => [
                        'sometimes',
                        function ($attribute, $value, $fail) {
                            if ($value !== 'foo') {
                                Rule::exists( 'App\Models\ProductCategory,id' );
                            }

                            return TRUE;
                        },
                    ],
                ];
            }
            default:
                break;
        }
    }

}
