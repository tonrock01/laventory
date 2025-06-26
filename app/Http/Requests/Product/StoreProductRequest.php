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
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'stock' => 'required|integer',
            'min_stock' => 'nullable|integer',
            /**
             * Cost price decimal 2 place
             * @var string
             * @example 10.00
             */
            'cost_price' => 'required|decimal:2',
            /**
             * Sale price decimal 2 place
             * @var string
             * @example 15.00
             */
            'sale_price' => 'required|decimal:2',
        ];
    }
}
