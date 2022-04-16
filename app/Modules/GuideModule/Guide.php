<?php

namespace App\Modules\GuideModule;

use App\Modules\AddressModule\Address;
use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RouteModule\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guide extends Model
{
    use SoftDeletes;

    protected $table = 'guides';
    protected $fillable = [
        'order_id',
        'branch_office',
        'transport_type',
        'dispatched',
        'address_name',
        'address_lat',
        'address_lng',
        'address_description',
        'description',
        'zone',
        'concept',
        'rate',
        'value',
        'corp_value',
        'customer_document_type',
        'contact',
        'phone_contact',
        'email_contact',
        'invoice_contact',
        'same_day_delivery',
        'sign',
        'take_photo',
        'packaging',
        'return_last_destination',
        'state',
        'app_status',
        'boxes',
        'status_matrix_id',
        'additional_address',
        'additional_email',
        'additional_phone',
    ];

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getRoute()
    {
        return $this->hasOne(Route::class, 'guide_id');
    }

    public function getTransportType()
    {
        return $this->belongsTo(ParameterValue::class, 'transport_type');
    }
    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office');
    }

    public function getState()
    {
        return $this->belongsTo(ParameterValue::class, 'state');
    }
}
