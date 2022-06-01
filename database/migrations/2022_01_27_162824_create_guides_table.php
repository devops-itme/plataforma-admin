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
            $table->integer('external_id')->nullable();
            $table->string('description')->nullable();
            $table->string('branch_office')->nullable();
            $table->string('transport_type')->nullable();
            $table->string('dispatched')->nullable();
            $table->integer('address_id')->nullable();
            $table->string('address_name')->nullable();
            $table->string('address_lat')->nullable();
            $table->string('address_lng')->nullable();
            $table->string('address_description')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable()->comment("Tealca field");
            $table->string('city')->nullable()->comment("Tealca field");
            $table->string('recipient_name')->nullable()->comment("Tealca field");
            $table->string('document_type')->nullable()->comment("Tealca field");
            $table->string('document')->nullable()->comment("Tealca field");
            // $table->string('phone')->nullable()->comment("Tealca field");
            // $table->string('email')->nullable()->comment("Tealca field");
            $table->string('delivery_office')->nullable()->comment("Tealca field");
            $table->string('pre_guide')->nullable()->comment("Tealca field");
            $table->string('invoice_number')->nullable()->comment("Tealca field");
            $table->string('declared')->nullable()->comment("Tealca field");
            $table->string('pieces')->nullable()->comment("Tealca field");
            $table->string('kg')->nullable()->comment("Tealca field");
            $table->json('boxes')->nullable();
            $table->string('concept')->nullable();
            $table->string('rate')->nullable();
            $table->double('value')->nullable();
            $table->double('corp_value')->nullable();
            $table->string('customer_document_type')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone_contact')->nullable();
            $table->string('email_contact')->nullable();
            $table->string('invoice_contact')->nullable();
            $table->string('detail_package')->nullable();
            $table->integer('same_day_delivery')->nullable();
            $table->integer('sign')->nullable();
            $table->integer('take_photo')->nullable();
            $table->integer('packaging')->nullable();
            $table->integer('return_last_destination')->nullable();
            $table->integer('state')->default(1);
            $table->integer('app_status')->nullable()->default(0)->comment("{0:Pendiente;1:Leído;}");
            $table->unsignedBigInteger('status_matrix_id')->nullable();
            $table->foreign('status_matrix_id')->references('id')->on('status_matrix');
            $table->string('additional_address')->nullable();
            $table->string('additional_email')->nullable();
            $table->string('additional_phone')->nullable();
            $table->string('novelty')->nullable();
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
