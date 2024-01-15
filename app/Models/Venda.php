<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;
    // protected $table = 'vendas'; // já ligado a tabela vendas    
    protected $fillable = [
        'id',
        'data',
        'total'
    ];


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function itensVenda()
    {
    	return $this->hasMany(ItemVenda::class);
    }

    public function cliente()
    {
    	return $this->belongsTo(Cliente::class);
    }
}
