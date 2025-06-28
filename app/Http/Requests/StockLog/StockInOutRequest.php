<?php

namespace App\Http\Requests\StockLog;

use Illuminate\Foundation\Http\FormRequest;

class StockInOutRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
            'reason' => 'string|max:255',
            'product_version' => 'required|integer'
        ];
    }
}
