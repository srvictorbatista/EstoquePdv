<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Fornecedor;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cnpj')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('cep')->nullable();
            $table->timestamps();
        });

        // Adiciona o fornecedor padrão
        Fornecedor::create([
            'id' => '0',
            'nome' => 'FORNECEDOR PADRÃO',
            'cnpj' => null,
            'email' => null,
            'telefone' => null,
            'endereco' => null,
            'bairro' => null,
            'cidade' => null,
            'cep' => null,
        ])->forceFill(['id' => 0])->save();

        // Atualiza o valor inicial do ID para 0
        Schema::table('fornecedores', function ($table) {
            DB::statement('ALTER TABLE fornecedores AUTO_INCREMENT = 0;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
