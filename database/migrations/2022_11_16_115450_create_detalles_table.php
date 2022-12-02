<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            //$table->double('precio');

            $table->unsignedBigInteger('recibo_id');
            $table->string('item')->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->string('descripcion');
            //$table->string('concepto');
            $table->string('cantidad');
            $table->string('valor_unitario'); // precio sin IGV
            $table->string('precio_unitario');
            $table->string('porcentaje_igv');
            $table->string('valor_total'); // ( precio sin IGV ) * cantidad
            $table->string('igv');
            $table->string('importe_total');
            $table->unsignedBigInteger('tipo_afectacion_id')->nullable();
            $table->unsignedBigInteger('tipo_conceptos_cobro_id');
            $table->string('mes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->foreign('recibo_id')->references('id')->on('recibos');
            $table->foreign('producto_id')->references('id')->on('servicios');
            $table->foreign('tipo_conceptos_cobro_id')->references('id')->on('tipo_conceptos_cobros');
            $table->foreign('tipo_afectacion_id')->references('id')->on('tipo_afectacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
