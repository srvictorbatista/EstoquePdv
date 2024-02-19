<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    // protected $table = 'compra'; // já ligado a tabela compra    
    protected $fillable = ['id','data','total'];


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function itensCompra()
    {
    	return $this->hasMany(ItemCempra::class);
    }
    
    public function relCompraProdutos()
    {
        return $this->belongsToMany(Produto::class, 'rel_compra_produto')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }

    public function relCompraFornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

}
