<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTealcaDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tealca_datas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('guide_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->Integer('external_id')->nullable();
            $table->string('contact')->nullable();
            // $table->datetime('created_date');
            $table->string('date_status')->nullable();
            $table->string('status')->nullable();
            $table->json('historical')->nullable();
            //$table->string('action');
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
        Schema::dropIfExists('tealca_datas');
    }
}
