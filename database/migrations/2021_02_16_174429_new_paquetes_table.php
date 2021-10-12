<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion','255')->nullable();
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_finaliza')->nullable();
            $table->boolean('estado')->default(true);
            $table->unsignedInteger('id_grupo');
            $table->foreign('id_grupo')->references('id')->on('grupos');
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
        Schema::dropIfExists('paquetes');
    }
}
