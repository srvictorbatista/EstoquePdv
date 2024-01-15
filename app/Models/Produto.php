<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
   // protected $table = 'produtos';    
    protected $fillable = [
    	'id',
    	'nome',
    	'descricao',
    	'preco',
    	'quantidade_em_estoque'
    ];

    //-- -------- Relacionamentos ----------------------------------------------------------------

    public function categoria()
    {
    	return $this->belongsTo(Categoria::class); 								// 1 pra 1 (inverso)
    }

    public function categorias()
    {
    	return $this->belongsToMany(Categoria::class, 'rel_categoriaprodutos'); 		// n para n (inverso)
    }

    public function itensVenda()
    {
    	return $this->hasMany(ItemVenda::class); 								// 1 para n
    }

    public function itensCompra()
    {
    	return $this->hasMany(ItemCompra::class); 								//  1 para n
    }
}


/*######################################################################################################################################################## /**
  Todas as relações do Eloquent para banco de dados relacionais:
/*######################################################################################################################################################## /**

hasOne:
Define uma relação "um para um" entre dois modelos.
Exemplo: Um usuário tem um perfil.

hasMany:
Define uma relação "um para muitos" entre dois modelos.
Exemplo: Um usuário pode ter vários posts.

belongsTo:
Define uma relação "pertence a" onde um modelo pertence a outro.
Exemplo: Um post pertence a um usuário.

belongsToMany:
Define uma relação "muitos para muitos" entre dois modelos, geralmente usando uma tabela intermediária.
Exemplo: Um usuário pode pertencer a muitos grupos e um grupo pode ter muitos usuários.

morphTo:
Define uma relação polimórfica que pode apontar para diferentes tipos de modelos.
Exemplo: Um comentário pode pertencer a um post ou a um vídeo.

morphOne:
Define uma relação polimórfica "um para um".
Exemplo: Um avatar pode pertencer a um usuário ou a um grupo.

morphMany:
Define uma relação polimórfica "um para muitos".
Exemplo: Uma entidade polimórfica pode ter muitos comentários.

morphToMany:
Define uma relação polimórfica "muitos para muitos".
Exemplo: Uma tag pode ser associada a vários posts ou vídeos.

morphedByMany:
Define uma relação polimórfica "muitos para muitos" do lado inverso.
Exemplo: Vários posts ou vídeos podem ter várias tags.

hasOneThrough:
Define uma relação "um para um" através de outra tabela.
Exemplo: Um país tem uma relação com um usuário através de uma tabela intermediária de cidades.

hasManyThrough:
Define uma relação "um para muitos" através de outra tabela.
Exemplo: Uma categoria tem vários posts através de uma tabela intermediária de postagem de categorias.

hasOneOrManyThrough:
Define dinamicamente se a relação é hasOne ou hasMany com base no número de registros retornados.
Útil quando você deseja otimizar consultas para evitar a criação de coleções desnecessárias.

/*######################################################################################################################################################## /**/
/*######################################################################################################################################################## /**/