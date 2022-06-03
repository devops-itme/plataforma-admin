<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusMatrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_matrix', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('scope_id')->nullable();
            $table->foreign('scope_id')->references('id')->on('parameter_values');
            $table->json('issues')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('status_matrix');
    }
}
