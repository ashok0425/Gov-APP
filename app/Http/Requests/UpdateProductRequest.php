<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'nullable|numeric',
            'is_great_deal' => 'boolean',
            'is_bestseller' => 'boolean',
            'sku' => 'nullable|string|max:100',
            'status' => 'nullable|boolean',
            'meta_title' => 'nullable',
            'meta_keyword' => 'nullable',
            'meta_description' => 'nullable',

        ];
    }
}
