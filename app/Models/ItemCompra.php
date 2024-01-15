<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    use HasFactory;
    protected $fillable = ['id','compra_id','produto_id','quantidade','preco_unitario','subtotal'];


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function Compra()
    {
    	return $this->belongsTo(Compra::class);
    }

    public function Produto()
    {
    	return $this->belongsTo(Produto::class);
    }
}
