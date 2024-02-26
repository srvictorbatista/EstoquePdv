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
    	// return $this->hasMany(ItemVenda::class, 'item_vendas');        // n para n (inverso)
        return $this->hasMany(ItemVenda::class, 'venda_id');
    }
    
    public function itensVendaU()
    {
        return $this->belongsToMany(Produto::class, 'item_vendas')
            ->withPivot('venda_id')
            ->withPivot('created_at')
            ->withPivot('updated_at');
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'rel_venda_cliente', 'venda_id', 'cliente_id')->withTimestamps();
    }

    public function relVendaCliente()
    {
        // return $this->hasMany(RelVendaCliente::class);
        return $this->belongsToMany(Cliente::class, 'rel_venda_cliente', 'venda_id', 'cliente_id')->withTimestamps();
    }
}
