<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    // protected $table = 'compra'; // já ligado a tabela compra    
    protected $fillable = [
    	'id',
    	'data',
    	'total'
    ];
    protected $dates = ['created_at', 'updated_at']; // Padroniza data no modelo (fusorario)


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function itensCompra()
    {
    	//return $this->hasMany(ItemCompra::class);
    	return $this->hasMany(ItemCompra::class, 'compra_id');
    }

    public function itensCompraU()
    {
        //*
        return $this->belongsToMany(Produto::class, 'item_compras')
            ->withPivot('compra_id')
            ->withPivot('created_at')
            ->withPivot('updated_at'); /**/

	    /*
	    return $this->belongsToMany(Produto::class, 'rel_venda_produto', 'venda_id', 'produto_id')
	        ->withPivot('quantidade', 'preco_unitario', 'subtotal')
	        ->withTimestamps();/**/
    }

    public function Fornecedores()
    {
        return $this->belongsToMany(Fornecedor::class, 'rel_compra_fornecedor', 'compra_id', 'fornecedor_id')->withTimestamps();
    }

    public function relCompraFornecedor()
    {
        // return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
        return $this->belongsToMany(Fornecedor::class, 'rel_compra_fornecedor', 'compra_id', 'fornecedor_id')->withTimestamps();
    }
    
    public function relCompraProdutos()
    {
        return $this->belongsToMany(Produto::class, 'item_compras', 'compra_id', 'produto_id')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }

}
