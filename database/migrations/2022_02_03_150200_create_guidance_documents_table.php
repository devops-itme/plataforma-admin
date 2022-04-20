<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidanceDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guidance_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guides_id')->references('id')->on('guides')->nullable();
            $table->string('url_document')->nullable();
            $table->foreignId('type')->references('id')->on('parameter_values')->nullable();
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
        Schema::dropIfExists('guidance_documents');
    }
}
