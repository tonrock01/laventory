<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'string|max:255|unique:products,name',
            'category_id' => 'integer|exists:categories,id',
            'stock' => 'integer',
            'min_stock' => 'integer',
            /**
             * Cost price decimal 2 place
             * @var string
             * @example 10.00
             */
            'cost_price' => 'decimal:2',
            /**
             * Sale price decimal 2 place
             * @var string
             * @example 15.00
             */
            'sale_price' => 'decimal:2',
        ];
    }
}
