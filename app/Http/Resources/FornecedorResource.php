<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FornecedorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'cep' => $this->cep,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
