<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaquetesAsignadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete_tarea', function (Blueprint $table) {
            $table->unsignedInteger('id_paquete');
            $table->foreign('id_paquete')->references('id_paquete')->on('paquetes');
            $table->unsignedInteger('id_tarea');
            $table->foreign('id_tarea')->references('id')->on('tareas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('paquetes_asignados');
    }
}
