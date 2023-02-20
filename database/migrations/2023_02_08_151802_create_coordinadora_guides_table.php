<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinadoraGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadora_guides', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->nullable();
            $table->bigInteger('identificacion_destinatario');
            $table->string('nombres_destinatario', 100)->nullable();
            $table->string('apellidos_destinatario', 100)->nullable();
            $table->string('direccion_destinatario', 500);
            $table->bigInteger('telefono_fijo_destinatario')->nullable();
            $table->bigInteger('telefono_celular_destinatario');
            $table->bigInteger('codigo_ciudad_destinatario');
            $table->string('nombre_ciudad_destinatario', 100);
            $table->bigInteger('codigo_pedido');
            $table->bigInteger('numero_pedido');
            $table->string('fechahora_pedido', 100)->nullable();
            $table->string('codigo_tienda', 1);
            $table->string('es_entrega_mismo_dia', 1);
            $table->float('valor_declarado');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->boolean('state')->nullable();
            $table->string('status', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinadora_guides');
    }
}
