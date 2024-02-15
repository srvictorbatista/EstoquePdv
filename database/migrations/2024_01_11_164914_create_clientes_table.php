<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Cliente;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // ->startingValue(0); // Define o valor inicial do ID como 0
            $table->text('nome');
            $table->text('cpf')->nullable();
            $table->text('email')->nullable();
            $table->text('telefone')->nullable();
            $table->text('endereco')->nullable();            
            $table->text('bairro')->nullable();            
            $table->text('cidade')->nullable();
            $table->text('cep')->nullable();
            $table->text('map')->nullable();
            $table->timestamps();
        });

        // Adiciona o cliente padrão
        Cliente::create([
            'id' => '0',
            'nome' => 'CLIENTE PADRÃO',
            'cpf' => null,
            'email' => null,
            'telefone' => null,
            'endereco' => null,
            'bairro' => null,
            'cidade' => null,
            'cep' => null,
            'map' => null,
        ])->forceFill(['id' => 0])->save();

        // Atualiza o valor inicial do ID para 0
        Schema::table('clientes', function ($table) {
            DB::statement('ALTER TABLE clientes AUTO_INCREMENT = 0;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};