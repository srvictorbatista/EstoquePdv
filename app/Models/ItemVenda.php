<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    use HasFactory;
    protected $fillable = ['id','venda_id','produto_id','quantidade','preco_unitario','subtotal'];


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function Venda()
    {
    	return $this->belongsTo(Venda::class);
    }

    public function Produto()
    {
    	return $this->belongsTo(Produto::class);
    }
}
