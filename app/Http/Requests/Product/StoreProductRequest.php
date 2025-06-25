<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|integer|exists:categories,id',
            'stock' => 'required|integer',
            'min_stock' => 'nullable|integer',
            'cost_price' => 'required|decimal:2',
            'sale_price' => 'required|decimal:2',
        ];
    }
}
