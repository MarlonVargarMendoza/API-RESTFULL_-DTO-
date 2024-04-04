<?php

namespace App\Http\Requests\Sale;

use App\DTO\StoreSaleData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class StoreSaleRequest extends FormRequest
{

    public array $ventas;

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
            'name.required' => 'Nombre es obligatorio.',
            'name.unique' => 'Nombre ya está en uso.',
            'products.*.id.required' => 'Producto ID es obligatorio',
            'products.*.quantity.required' => 'Cantidad es obligatorio',
            'products.*.quantity.integer' => 'Cantidad es numerico'
        ];
    }

    public function passedValidation ()
    {
        foreach ($this->products as $dataProducto) {

            $this->ventas[] = new StoreSaleData(
                $this->name,
                $dataProducto['id'],
                $dataProducto['quantity']
            );
        }
    }
}
