<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('termino');
            $table->string('path_pdf')->nullable();
            $table->date('femision');

            $table->unsignedBigInteger('emisor_id');
            $table->string('tipo_comprobante_id');
            $table->string('tipo');
            $table->unsignedBigInteger('serie_id')->nullable();
            $table->string('serie');
            $table->string('correlativo')->nullable();
            $table->string('forma_pago');
            $table->date('f_emision');
            $table->string('f_vencimiento');
            $table->string('moneda_id');
            $table->string('op_gravadas')->nullable();
            $table->string('op_exoneradas')->nullable();
            $table->string('op_inafectas')->nullable();
            $table->string('igv');
            $table->double('total');
            $table->unsignedBigInteger('cliente_id');
            $table->string('tipo_comprobante_ref_id')->nullable();
            $table->unsignedBigInteger('comprobante_ref_id')->nullable();
            $table->string('serie_ref')->nullable();
            $table->string('correlativo_ref')->nullable();
            $table->string('codmotivo')->nullable();
            $table->unsignedBigInteger('cajero_id')->nullable();
            $table->text('cestado')->nullable();
            $table->string('nombrexml')->nullable();
            $table->text('xmlbase64')->nullable();
            $table->string('hash')->nullable();
            $table->text('cdrbase64')->nullable();
            $table->string('codigo_sunat')->nullable();
            $table->text('mensaje_sunat')->nullable();
            $table->string('estado_comprobante')->nullable();
            $table->char("imagen_deposito")->nullable();
            $table->char("tipo_deposito")->nullable();
            $table->string('obs_ref')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->foreign('emisor_id')->references('id')->on('emisors');
            $table->foreign('tipo_comprobante_id')->references('id')->on('tipo_comprobantes');
            $table->foreign('serie_id')->references('id')->on('series');
            $table->foreign('moneda_id')->references('id')->on('monedas');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('tipo_comprobante_ref_id')->references('id')->on('tipo_comprobantes');
            $table->foreign('comprobante_ref_id')->references('id')->on('recibos');
            $table->foreign('cajero_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibos');
    }
}
