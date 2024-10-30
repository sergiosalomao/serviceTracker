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
        Schema::create('movimentos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('tipo')->notnull();
            $table->string('data')->nullable();

        

            
            $table->integer('centro_id')->notnull()->unsigned();
            $table->foreign('centro_id')->references('id')->on('centros');
            
            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('contas');
            
            $table->integer('fluxo_id')->notnull()->unsigned();
            $table->foreign('fluxo_id')->references('id')->on('fluxos');

        
            
            $table->string('descricao')->nullable();
            $table->decimal('valor', 10, 2)->notnull();
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
        Schema::dropIfExists('movimentos');
    }
};
