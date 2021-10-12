<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres','255')->nullable();
            $table->string('apellidos','255')->nullable();
            $table->string('username', '100')->unique();
            $table->text('password',0);
            $table->date('fecha_nacimiento');
            $table->string('image','255');
            $table->boolean('estado');
            $table->unsignedInteger('id_grupo');
            $table->foreign('id_grupo')->references('id_grupo')->on('grupos');
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
        Schema::dropIfExists('users');
    }
}
