<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id')->nullable();
            // $table->foreign('zone_id')->references('id')->on('zones');
            $table->unsignedBigInteger('package_type')->nullable();
            // $table->foreign('package_type')->references('id')->on('parameter_values');
            $table->string('estimated_time')->nullable();
            $table->double('extra_for_weight')->nullable();
            $table->double('extra_per_size')->nullable();
            $table->double('percentage_immediate_delivery')->nullable();
            $table->binary('special_rate')->nullable();
            $table->integer('state')->nullable();
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
        Schema::dropIfExists('rates');
    }
}
