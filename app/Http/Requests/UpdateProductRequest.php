<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'category_id' => 'exists:category,id',
            'name' => 'string|unique:product,name,' . $this->product->id . ',id',
            'buy_price' => 'numeric|min:0',
            'sell_price' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
        ];
    }
}
