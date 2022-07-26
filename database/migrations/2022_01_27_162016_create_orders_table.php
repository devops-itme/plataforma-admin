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
            $table->string('order_number');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('order_type');
            $table->integer('document_type')->nullable();
            $table->double('order_value')->nullable();
            $table->double('receive_by_COD')->nullable();
            $table->double('internal_product')->nullable();
            $table->double('expenses')->nullable();
            $table->double('diligence_expenses')->nullable();
            $table->double('tax_total')->nullable();
            $table->integer('vehicle_type_id')->nullable();
            $table->integer('payment_method')->nullable();
            $table->integer('user_payment_method')->nullable();
            $table->integer('urgent_dispatch')->nullable();
            $table->date('schedule_date')->nullable();
            $table->integer('schedule_time')->nullable();
            $table->string('schedule_time_range')->nullable();
            $table->double('insured_value')->nullable();
            $table->double('money_to_collect')->nullable();
            $table->double('percentage_to_collect')->nullable()->comment('Porcentaje de seguro');
            $table->integer('customer_user_id');
            $table->integer('creator_user_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('dispatched')->unique()->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('address_name')->nullable();
            $table->string('address_lat')->nullable();
            $table->string('address_lng')->nullable();
            $table->string('address_description')->nullable();
            $table->string('description')->nullable();
            $table->integer('state')->default(1)->nullable();
            $table->integer('app_status')->nullable()->default(0)->comment("{0:Pendiente;1:Leído;}");
            $table->unsignedBigInteger('status_matrix_id')->nullable();
            $table->foreign('status_matrix_id')->references('id')->on('status_matrix');
            $table->integer('paid')->nullable()->default(0);
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
