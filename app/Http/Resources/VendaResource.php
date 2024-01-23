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
        	'data'			 => $this->data,
        	'total'			 => $this->total,
        	// 'produtos_id'	 => VendaResource::collection($this->produtos_id),
        	// 'produto_id' 	 => $this->produto_id,
            'produto_id'     => 'array',
            'quantidade'     => 'array',
            'preco_unitario' => 'array',
        	'created_at' 	 => $this->created_at,
        	'updated_at'	 => $this->updated_at,
        ];
    }
}
