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
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('order_type')->nullable();
            $table->integer('document_type')->nullable();
            $table->double('order_value');
            $table->double('receive_by_COD');
            $table->double('internal_product');
            $table->double('expenses');
            $table->double('diligence_expenses');
            $table->double('tax_total');
            $table->integer('payment_method');
            $table->integer('urgent_dispatch');
            $table->integer('return_last_destination');
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->double('insured_value')->nullable();
            $table->double('money_to_collect')->nullable();
            $table->double('percentage_to_collect')->nullable()->comment('Porcentaje de seguro');
            $table->integer('customer_user_id');
            $table->integer('creator_user_id')->nullable();
            $table->integer('zone')->nullable();
            $table->string('dispatched')->unique()->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('state')->default(32)->comment("{1:Por despachar;2:Despachado;3:Completado}");
            $table->integer('app_status')->nullable()->default(0)->comment("{0:Pendiente;1:Leído;}");
            $table->unsignedBigInteger('status_matrix_id')->nullable();
            $table->foreign('status_matrix_id')->references('id')->on('status_matrix');
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
