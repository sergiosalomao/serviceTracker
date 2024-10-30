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
        Schema::create('itenssolicitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('solicitacao_id')->unsigned();
            $table->foreign('solicitacao_id')->references('id')->on('solicitacoes');
            $table->integer('servico_id')->unsigned();
            $table->foreign('servico_id')->references('id')->on('servicos');
            $table->integer('qtd')->default(1);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('itenssolicitacoes');
    }
};
