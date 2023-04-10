<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinadoraCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadora_cities', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_ciudad', 100);
            $table->string('departamento', 100);
            $table->string('acepta_pago_contra_entrega', 10);
            $table->string('codigo_ciudad', 8);
            $table->string('pais', 100);
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
        Schema::dropIfExists('coordinadora_cities');
    }
}
