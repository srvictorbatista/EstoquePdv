<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    // protected $table = 'categorias';    
    protected $fillable = ['id', 'nome'];
    protected $dates = ['created_at', 'updated_at']; // Padroniza data no modelo (fusorario)

    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function produtos()
    {
    	return $this->hasMany(Categoria::class)->withTimestamps(); 
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
