<?php

namespace App\Modules\OrderModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class AlasOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alas_orders';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'box_reference',
        'itx_code',
        'shipping_type',
        'weight_in_grams',
        'Length',
        'Width',
        'Height',
        'Volume',
        'departure_date_utc',
        'customer_name',
        'customer_last_name',
        'customer_address1',
        'customer_address2',
        'customer_city',
        'customer_postal_code',
        'customer_province',
        'customer_country_iso',
        'phone_number1',
        'phone_number2',
        'email',
        'remarks',
        'courier_code',
        'courier_description',
        'currency_iso_code',
        'preferred_language_iso',
        'destinity_store',
        'drop_point',
        'drop_point_user',
        'defined_delivery_date',
        'defined_delivery_time',
        'brand',
        'tracking_number',
        'source_warehouse',
        'courier_service_code',
        'package_type',
        'customer_order_number',
        'defined_delivery_date',
        'defined_delivery_time',
        'drop_point',
        'drop_point_user'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function createOrder($request)
    {
        # code...
    }

    public function getOrders()
    {
        # code...
    }

    public function getOrder($order_id)
    {
        # code...
    }
}
