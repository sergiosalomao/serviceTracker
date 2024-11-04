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
        Schema::create('cobrancas', function (Blueprint $table) {
            $table->id();
            // $table->integer('solicitacao_id')->notnull()->unsigned();
            //  $table->foreign('solicitacao_id')->references('id')->on('solicitacoes');

            $table->unsignedBigInteger('solicitacao_id');
            $table->foreign('solicitacao_id')
                ->references('id')
                ->on('solicitacoes')
                ->onDelete('cascade'); // Deleção em cascata
            $table->decimal('valor_total', 10, 2);
            $table->decimal('entrada', 10, 2)->nullable()->default('0');;
            $table->decimal('desconto', 10, 2)->nullable()->default('0');;
            $table->date('data_vencimento');
            $table->integer('parcelas')->nullable()->default('1');;
            $table->string('status')->default('PENDENTE'); // Status: pendente, pago, vencido
            $table->integer('forma_pagamento')->unsigned();
            $table->foreign('forma_pagamento')->references('id')->on('formas_pagamento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobrancas');
    }
};
