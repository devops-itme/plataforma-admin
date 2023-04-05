<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlasOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alas_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->nullable();
            $table->string('box_reference', 33)->nullable();
            $table->string('itx_code', 30)->nullable();
            $table->string('shipping_type', 5)->nullable();
            $table->string('weight_in_grams', 10)->nullable();
            $table->string('Length', 5)->nullable();
            $table->string('Width', 5)->nullable();
            $table->string('Height', 5)->nullable();
            $table->string('Volume', 5)->nullable();
            $table->string('departure_date_utc', 14)->nullable();
            $table->string('customer_name', 60)->nullable();
            $table->string('customer_last_name', 60)->nullable();
            $table->string('customer_address1', 150)->nullable();
            $table->string('customer_address2', 150)->nullable();
            $table->string('customer_city', 60)->nullable();
            $table->string('customer_postal_code', 15)->nullable();
            $table->string('customer_province', 60)->nullable();
            $table->string('customer_country_iso', 5)->nullable();
            $table->string('phone_number1', 60)->nullable();
            $table->string('phone_number2', 60)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('remarks', 150)->nullable();
            $table->string('courier_code', 20)->nullable();
            $table->string('courier_description', 100)->nullable();
            $table->string('payment_type', 5)->nullable();
            $table->string('total_value', 10)->nullable();
            $table->string('amount_pending', 10)->nullable();
            $table->string('currency_iso_code', 5)->nullable();
            $table->string('preferred_language_iso', 5)->nullable();
            $table->string('destinity_store', 9)->nullable();
            $table->string('drop_point', 30)->nullable();
            $table->string('drop_point_user', 60)->nullable();
            $table->string('defined_delivery_date', 14)->nullable();
            $table->string('defined_delivery_time', 30)->nullable();
            $table->string('brand', 50)->nullable();
            $table->string('tracking_number', 50)->nullable();
            $table->string('source_warehouse', 50)->nullable();
            $table->string('courier_service_code', 50)->nullable();
            $table->string('package_type', 5)->nullable();
            $table->string('customer_order_number', 50)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('external_seller', 50)->nullable();
            $table->string('external_order_id', 50)->nullable();
            $table->string('dangerous_goods')->nullable();
            $table->string('second_life')->nullable();
            $table->string('origin_location_id_numeric', 50)->nullable();
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
        Schema::dropIfExists('alas_orders');
    }
}
