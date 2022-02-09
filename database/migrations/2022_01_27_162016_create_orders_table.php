<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('service_type_id');
            $table->foreign('service_type_id')->references('id')->on('parameter_values');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->foreign('vehicle_type_id')->references('id')->on('parameter_values');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('id')->on('parameter_values');
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->boolean('express_delivery')->nullable()->comment('{0:No;1:Urgent}');
            $table->boolean('last_destination_return')->nullable()->comment('{0:No;1:Yes}');
            $table->integer('insured_value');
            $table->integer('percentage_receivable');
            $table->integer('value_receivable');
            $table->integer('state')->default(1)->comment("{0:Inactive;1:Active}");
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
        Schema::dropIfExists('orders');
    }
}
