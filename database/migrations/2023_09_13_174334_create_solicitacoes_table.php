<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->date('data_solicitacao')->null();
            $table->date('data_final')->nullable()->default(null);;
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->decimal('valor', 10, 2)->nullable();
            $table->decimal('entrada', 10, 2)->nullable();
            $table->decimal('desconto', 10, 2)->nullable();
            $table->string('status')->nullable()->default('AGUARDANDO APROVAÇÃO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitacoes');
    }
};
