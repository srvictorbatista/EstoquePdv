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
    protected $dates = ['created_at', 'updated_at']; // Padroniza data no modelo (fusorario)


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
