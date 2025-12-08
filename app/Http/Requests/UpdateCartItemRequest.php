<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1|max:999'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'quantity.required' => 'Quantity harus diisi.',
            'quantity.integer' => 'Quantity harus berupa angka.',
            'quantity.min' => 'Quantity minimal 1.',
            'quantity.max' => 'Quantity maksimal 999.',
        ];
    }
}