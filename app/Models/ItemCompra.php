<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    use HasFactory;
    protected $fillable = ['id','compra_id','produto_id','quantidade','preco_unitario','subtotal'];
    protected $dates = ['created_at', 'updated_at']; // Padroniza data no modelo (fusorario)


    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function Compra()
    {
    	return $this->belongsTo(Compra::class);
    }

    public function Produto()
    {
    	return $this->belongsTo(Produto::class);
    }

    //* Padroniza data no modelo (fuso horário)
    public function toArray()
    {
        $array = parent::toArray();

        foreach ($this->getDates() as $date) {
            if (isset($array[$date])) {
                $array[$date] = $this->$date->setTimezone('America/Belem')->toDateTimeString();
            }
        }

        return $array;
    }
}
