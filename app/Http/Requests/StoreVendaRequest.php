<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendaRequest extends FormRequest
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
           'data'           => 'nullable|sometimes|date|min:3',
           'cliente_id'     => 'array',
           'total'          => 'string|min:0',
           'produto_id'     => 'array',
           'quantidade'     => 'array',
           'preco_unitario' => 'array',
        ];
    }
}
