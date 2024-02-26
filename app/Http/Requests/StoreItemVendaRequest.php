<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemVendaRequest extends FormRequest
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
           'venda_id'       => 'required|numeric|min:1',
           'produto_id'     => 'required|numeric|min:1',
           'quantidade'     => 'nullable|numeric|min:0',
           'preco_unitario' => 'nullable|string|min:0', 
           'subtotal'       => 'numeric|min:0',
        ];
    }
}
