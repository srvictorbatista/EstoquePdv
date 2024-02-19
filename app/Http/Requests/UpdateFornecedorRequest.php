<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFornecedorRequest extends FormRequest
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
            'nome' 		=> 'required|string|min:3',
            'cnpj' 		=> 'nullable|string',  // '|unique:Fornecedores',
            'email' 	=> 'nullable|string',  // '|nullable|email|unique:Fornecedores,email', // validacao complementada no controller
            'telefone' 	=> 'required|string',
            'endereco' 	=> 'nullable|string',
            'bairro' 	=> 'nullable|string',
            'cidade' 	=> 'nullable|string',
            'cep' 		=> 'nullable|string|min:0',
        ];
    }
}
