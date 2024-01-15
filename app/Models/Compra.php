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

    /*
    public function fornecedor()
    {
    	return $this->belongsTo(Cliente::class);
    } /**/
}
