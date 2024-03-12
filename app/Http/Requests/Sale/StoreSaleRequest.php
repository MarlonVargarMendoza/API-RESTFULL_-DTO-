<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StoreSaleRequest extends FormRequest
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
            'name' => 'required | unique:App\Models\User,name',
            'products' => 'required|array',
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'El nombre ya está en uso.',
            'products.*.id.required' => 'producto ID es obligatorio',
            'products.*.quantity.required' => 'Cantidad del producto es obligatorio',
            'products.*.quantity.integer' => 'Cantidad del producto es numerico'
        ];
    }
}
