<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'nome'     => 'required|string|min:3',
            // 'cpf'      => 'nullable|string|cpf|max:24', /*unique:clientes|*/
            'cpf'      => 'nullable|string|unique:clientes',
            'email'    => 'nullable|string', //'nullable|email|unique:clientes,email', // validacao complementada no controller
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
            'bairro'   => 'nullable|string',
            'cidade'   => 'nullable|string',
            'cep'      => 'nullable|string|min:9',
            'map'      => 'nullable|string|min:0',
        ];
    }
}
