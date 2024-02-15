<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [        	
        	'id'			 => $this->id,
            'cliente' 		 => $this->relVendaCliente->map(function ($cliente) {
                return [
                    'cliente_id' => $cliente->id,
                    'nome'       => $cliente->nome,
                    'cpf'        => $cliente->cpf,
                    'telefone'   => $cliente->telefone,
                    'endereco'   => $cliente->endereco,
                    'bairro'     => $cliente->bairro,
                    'cidade'     => $cliente->cidade,
                ];
            }),
        	'data'			 => $this->data,
        	'total'			 => $this->total,
	        'itens'    		 => $this->itensVenda->map(function($itemVenda){
	            return [
	            	'nome'        	 => $itemVenda->produto->nome,
	            	'descricao'  	 => $itemVenda->produto->descricao,
	                'produto_id'     => $itemVenda->produto_id,
	                'quantidade'     => $itemVenda->quantidade,
	                'preco_unitario' => $itemVenda->preco_unitario,
	                'subtotal'		 => $itemVenda->subtotal,
	                /* relacao de itens no estoque (tabela produtos)
	                'produto'        => [
	                    'id'          => $itemVenda->produto->id,
	                    'nome'        => $itemVenda->produto->nome,
	                    'descricao'   => $itemVenda->produto->descricao,
	                    'preco'   	  => $itemVenda->produto->preco,
	                    'quantidade_em_estoque'   => $itemVenda->produto->quantidade_em_estoque
	                ],/**/
	            ];
	        }),
        	// 'created_at' 	 => $this->created_at,
        	// 'updated_at'	 => $this->updated_at,
        ];
    }
}