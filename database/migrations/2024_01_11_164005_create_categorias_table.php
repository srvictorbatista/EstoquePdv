<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Categoria;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id(); // ->startingValue(0); // Define o valor inicial do ID como 0
            $table->text('nome');
            $table->timestamps();
        });

        // Adiciona a categoria padrão
        Categoria::create([
            'id' => 0,
            'nome' => 'CATEGORIA PADRÃO',
        ])->forceFill(['id' => 0])->save();

        // Atualiza o valor inicial do ID para 0
        Schema::table('categorias', function ($table) {
            DB::statement('
                ALTER TABLE categorias AUTO_INCREMENT = 0,

                -- Adição devido à falta de funcionamento padrão da função timestamps(), especificamente nesta tabela.
                MODIFY COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                MODIFY COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
            ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
