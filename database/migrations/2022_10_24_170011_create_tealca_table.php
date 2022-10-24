<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTealcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tealca', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('guide_id');
            $table->bigInteger('order_id');
            $table->Integer('external_id');
            $table->string('contact');
            // $table->datetime('created_date');
            $table->string('date_status');
            $table->string('status');
            $table->string('action');
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
        Schema::dropIfExists('tealca');
    }
}
