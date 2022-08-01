<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('status_matrix_id');
            $table->foreign('status_matrix_id')->references('id')->on('status_matrix');
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->foreign('issue_id')->references('id')->on('parameter_values');
            $table->unsignedBigInteger('sign_customer')->nullable();
            $table->foreign('sign_customer')->references('id')->on('guidance_documents');
            // $table->string('sign_customer');
            $table->text('detail_log')->nullable();
            $table->json('url_document')->nullable();
            $table->string('novelty')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('guide_logs');
    }
}
