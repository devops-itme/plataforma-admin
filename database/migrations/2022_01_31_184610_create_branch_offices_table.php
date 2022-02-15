<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            // $table->foreign('zone_id')->references('id')->on('zones');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->integer('document_type')->nullable()->comment("it's a parameter_value");
            $table->string('document_number')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->integer('default')->nullable();
            $table->integer('payment_method')->nullable();
            $table->string('phone')->nullable();
            $table->integer('usage_mode')->nullable()->comment("it's a parameter_value");
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->integer('state')->default(1);
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
        Schema::dropIfExists('branch_offices');
    }
}
