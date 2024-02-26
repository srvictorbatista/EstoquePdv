<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompraRequest extends FormRequest
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
           'fornecedor_id'  => 'array',
           'data'           => 'string|min:3',
           'total'          => 'string|min:0',
           'produto_id'     => 'array',
           'quantidade'     => 'array',
           'preco_unitario' => 'array',
           /*
            'data' => 'required|date_format:Y-m-d H:i:s',
            'total' => 'required|numeric',
            'itens' => 'required|array|min:1',
            'itens.*.id' => 'required|exists:item_compras,id',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.preco_unitario' => 'required|numeric|min:0',
            'itens.*.subtotal' => 'required|numeric|min:0',
            'fornecedores' => 'required|array|min:1',
            'fornecedores.*' => 'required|exists:fornecedores,id',
           /**/
        ];
    }
}
