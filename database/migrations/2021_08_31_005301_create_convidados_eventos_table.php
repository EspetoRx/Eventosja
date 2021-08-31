<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvidadosEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convidados_eventos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convidado_id');
            $table->unsignedBigInteger('evento_id');
            $table->timestamps();
            $table->foreign('convidado_id')->references('id')->on('convidados')->onDelete('cascade');
            $table->foreign('evento_id')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convidados_eventos');
    }
}
