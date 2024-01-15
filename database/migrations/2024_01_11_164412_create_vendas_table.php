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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data')->nullable(); // Certifique-se de permitir valores nulos
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
        // Definindo o valor padrão para a coluna 'data' se estiver vazia
        DB::statement("ALTER TABLE vendas MODIFY data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
