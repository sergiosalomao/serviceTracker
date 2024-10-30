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
        Schema::create('campanhas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->notnull();
            $table->text('descricao')->notnull();
            $table->string('limite')->notnull();
            $table->decimal('desconto', 10, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('qtd_cupons')->notnull();
            $table->string('gera_cupom')->notnull();
            $table->string('foto_path')->nullable();

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
        Schema::dropIfExists('campanhas');
    }
};
