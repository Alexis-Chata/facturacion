<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('valor_unitario'); // precio sin IGV
            $table->string('precio_unitario');
            $table->unsignedBigInteger('tipo_afectacion_id')->nullable();
            $table->unsignedBigInteger('tipo_conceptos_cobro_id')->nullable();
            $table->string('unidad_id')->nullable();
            $table->string('codigo_sunat')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->foreign('tipo_afectacion_id')
                ->references('id')
                ->on('tipo_afectacions');

            $table->foreign('tipo_conceptos_cobro_id')
                ->references('id')
                ->on('tipo_conceptos_cobros');

            $table->foreign('unidad_id')
                ->references('id')
                ->on('unidads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
