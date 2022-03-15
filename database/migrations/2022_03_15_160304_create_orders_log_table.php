<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_log', function (Blueprint $table) {
            $table->id();
            $table->integer('state');
            $table->datetime('datetime');
            $table->string('url_document')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('order_id');
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
        Schema::dropIfExists('orders_log');
    }
}
