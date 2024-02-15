<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelVendaCliente extends Model
{
    protected $table = 'rel_venda_cliente';
    protected $fillable = ['venda_id', 'cliente_id'];
    protected $dates = ['created_at', 'updated_at']; // Padroniza data no modelo (fusorario)
    public $timestamps = true;


    //-- -------- Relacionamentos ----------------------------------------------------------------
    
    public function cliente()
    {
        // belongsToMany
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
}
