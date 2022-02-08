<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guide_id')->nullable();
            // $table->foreign('guide_id')->references('id')->on('guides');
            $table->double('weight')->nullable();
            $table->double('long')->nullable();
            $table->double('broad')->nullable();
            $table->double('high')->nullable();
            $table->double('vol_weight')->nullable();
            $table->string('description')->nullable();
            $table->integer('state')->default(1)->comment("{0:Inactive;1:Active}")->nullable();
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
        Schema::dropIfExists('boxes');
    }
}
