<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// return new class extends Migration
class CreateRelVendaClienteTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rel_venda_cliente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');
            $table->unsignedBigInteger('cliente_id');
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_venda_cliente');
    }
};
