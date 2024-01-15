<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    // protected $table = 'venda'; // já ligado a tabela venda  
    protected $fillable = ['id','nome','email', 'telefone'];


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function venda()
    {
        return $this->hasMany(Venda::class);
    }
}
