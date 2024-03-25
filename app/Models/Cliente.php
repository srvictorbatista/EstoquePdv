<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    // protected $table = 'clientes'; // já ligado a tabela clientes  
    protected $fillable = ['id','nome', 'cpf', 'email', 'telefone', 'endereco','bairro','cidade','cep', 'map'];
    protected $dates = ['created_at', 'updated_at']; // Padroniza data no modelo (fusorario)


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function venda()
    {
        return $this->hasMany(Venda::class);
    }

    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'rel_venda_cliente', 'cliente_id', 'venda_id');
    }

    public function relVendaCliente()
	{
	    return $this->belongsToMany(Venda::class, 'rel_venda_cliente', 'cliente_id', 'venda_id');
	}

    //* Padroniza data no modelo (fusorario)
    public function toArray()
    {
        $array = parent::toArray();

        foreach ($this->getDates() as $date) {
            if (isset($array[$date])) {
                $array[$date] = $this->$date->setTimezone('America/Belem')->toDateTimeString();
            }
        }

        return $array;
    }/**/
}
