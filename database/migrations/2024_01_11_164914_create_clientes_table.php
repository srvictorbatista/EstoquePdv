<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};