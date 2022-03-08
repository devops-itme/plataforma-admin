<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            // $table->foreign('order_id')->references('id')->on('orders');
            $table->string('branch_office')->nullable();
            $table->string('transport_type')->nullable();
            $table->string('dispatched')->nullable();
            $table->string('address_name')->nullable();
            $table->string('address_lat')->nullable();
            $table->string('address_lng')->nullable();
            $table->string('address_description')->nullable();
            $table->string('zone')->nullable();
            $table->string('concept')->nullable();
            $table->string('rate')->nullable();
            $table->double('value')->nullable();
            $table->double('corp_value')->nullable();
            $table->string('document_type_customes')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone_contact')->nullable();
            $table->string('email_contact')->nullable();
            $table->string('invoice_contact')->nullable();
            $table->integer('same_day_delivery')->nullable();
            $table->integer('sign')->nullable();
            $table->integer('take_photo')->nullable();
            $table->integer('packaging')->nullable();
            $table->unsignedBigInteger('customer_address')->nullable();
            $table->integer('state')->default(32)->comment("{1:Por despachar;2:Despachado;3:Completado}");
            $table->integer('app_status')->nullable()->default(0)->comment("{0:Pendiente;1:Leído;}");
            $table->json('boxes')->nullable();
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
        Schema::dropIfExists('guides');
    }
}
