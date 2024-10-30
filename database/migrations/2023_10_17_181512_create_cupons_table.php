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
        Schema::create('cupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->unique();
            $table->integer('campanha_id')->notnull()->unsigned();
            $table->foreign('campanha_id')->references('id')->on('campanhas');
            $table->string('limite')->nullable();
            $table->integer('cliente_id')->nullable()->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('status')->nullable();
            $table->decimal('desconto', 10, 2)->nullable();
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
        Schema::dropIfExists('cupons');
    }
};
