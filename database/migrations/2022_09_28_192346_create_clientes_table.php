<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->unsignedBigInteger('tcliente_id')->nullable();
            $table->string('identificacion')->unique();
            $table->string('email');
            $table->string('email2')->nullable();
            $table->string('direccion')->nullable();
            $table->string('celular')->nullable();
            $table->foreign('tcliente_id')->references('id')->on('tclientes')->onDelete('set null');
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
        Schema::dropIfExists('clientes');
    }
}
