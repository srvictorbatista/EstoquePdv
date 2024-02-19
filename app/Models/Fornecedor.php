<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores'; // Nao foi capaz de auto-identificar a tabela correta
    protected $fillable = ['nome', 'cnpj', 'email', 'telefone', 'endereco', 'bairro', 'cidade', 'cep'];
    protected $dates = ['created_at', 'updated_at'];

    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function relFornecedorCompras()
    {
        return $this->hasMany(Compra::class, 'fornecedor_id');
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
