<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'venda_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'subtotal'
    ];


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function Venda()
    {
    	// return $this->belongsTo(Venda::class);
        return $this->belongsTo(Venda::class, 'venda_id');
    }

    public function Produto()
    {
    	// return $this->belongsTo(Produto::class);
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
