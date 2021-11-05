<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
                    'name' => 'required|string|min:3|max:191',
                    'status' => 'required|numeric|boolean',
                    'featured' => 'required|numeric|boolean',
                    'qty' => 'required|numeric',
                    'price' => 'required|numeric',
                    'category_id' => 'required|exists:App\Models\ProductCategory,id',
                    'tag_id.*' => 'required|exists:App\Models\Tag,id',
                    'desc' => 'required',
                    'img' => 'required',
                    'img.*' => 'mimes:jpg,jpeg,png,gif|max:20000',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|min:3|max:191',
                    'status' => 'required|numeric|boolean',
                    'featured' => 'required|numeric|boolean',
                    'qty' => 'required|numeric',
                    'price' => 'required|numeric',
                    'category_id' => 'required|exists:App\Models\ProductCategory,id',
                    'tag_id.*' => 'required|exists:App\Models\Tag,id',
                    'desc' => 'required',
                    'img' => 'nullable',
                    'img.*' => 'mimes:jpg,jpeg,png,gif|max:20000',
                ];
            }
            default:
                break;
        }
    }

}
