<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemVendaResource extends JsonResource
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
        	'venda_id'		 => $this->venda_id,
        	'produto_id'	 => ProdutoResource::collection($this->produto_id),
        	'quantidade'	 => $this->quantidade,
        	'preco_unitario' => $this->preco_unitario,
        	'subtotal'		 => $this->subtotal,
        	'created_at'	 => $this->created_at,
        	'updated_at'	 => $this->updated_at,        	
        ];
    }
}
