<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->string('contact')->nullable();
            $table->string('payment_period')->nullable();
            $table->string('credit')->nullable();
            $table->integer('taxes')->nullable();
            $table->integer('receive_emails')->nullable();
            $table->integer('fullfill')->nullable();
            $table->integer('handling')->nullable();
            $table->integer('COD_value')->nullable();
            $table->string('business_name')->nullable();
            $table->string('tradename')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
