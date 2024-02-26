<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
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
            'fornecedor_id'     => 'nullable|exists:fornecedores,id',
            'produto_id.*'      => 'required|exists:produtos,id',
            'quantidade.*'      => 'nullable|integer|min:1',
            'preco_unitario.*'  => 'nullable|string|min:0',
        ];
    }

    /* As mensagens a baixo foram migradas para o controller
    public function messages()
    {
        return [
            'fornecedor_id.required'        => 'O campo fornecedor é obrigatório.',
            'fornecedor_id.exists'          => 'O fornecedor selecionado é inválido.',
            'produto_id.*.required'         => 'O campo produto é obrigatório.',
            'produto_id.*.exists'           => 'Um ou mais produtos selecionados são inválidos.',
            'quantidade.*.required'         => 'O campo quantidade é obrigatório.',
            'quantidade.*.integer'          => 'A quantidade deve ser um número inteiro.',
            'quantidade.*.min'              => 'A quantidade mínima é 1.',
            'preco_unitario.*.required'     => 'O campo preço unitário é obrigatório.',
            'preco_unitario.*.numeric'      => 'O preço unitário deve ser um número.',
            'preco_unitario.*.min'          => 'O preço unitário mínimo é 0.',
        ];
    }/**/
}
