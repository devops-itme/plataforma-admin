<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinadoraOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadora_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('coordinadora_guides');
            $table->string('referencia', 50)->nullable();
            $table->integer('unidades')->nullable();
            $table->float('peso', 12, 2)->nullable();
            $table->float('alto', 12, 2)->nullable();
            $table->float('ancho', 12, 2)->nullable();
            $table->float('largo', 12, 2)->nullable();
            $table->string('nombre_empaque', 500)->nullable();
            $table->boolean('state')->nullable();
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
        Schema::dropIfExists('coordinadora_order_details');
    }
}
