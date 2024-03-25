<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
           'nome'                   => 'string|min:3',
           'descricao'              => 'string',
           'quantidade_em_estoque'  => 'integer|min:0', 
           'preco'                  => 'string|min:0',
           'categoria_id'           => 'array',
        ];
    }
}
