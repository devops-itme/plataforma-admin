<?php

namespace App\Modules\GuideModule;

use App\Modules\AddressModule\Address;
use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RouteModule\Route;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Guide extends Model
{
    use SoftDeletes, LogsActivity;

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
        'issue_id',
        'additional_address',
        'additional_email',
        'additional_phone',
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = "Se ha " . __($eventName) . " la guiá " . $activity->subject->fullName;
        }
    }
    /*End logs config */

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getRoute()
    {
        return $this->hasOne(Route::class, 'guide_id');
    }

    public function getStatusMatrix()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
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

    public function getDocuments()
    {
        return $this->hasMany(GuidanceDocument::class, 'guides_id');
    }
    // public function getIssue()
    // {
    //     return $this->belongsTo(StatusMatrix::class, 'issue_id');
    // }

    // Scopes

    public function scopeWhereStatusMatrix($query, $status_matrix_id)
    {
        if (!is_null($status_matrix_id)) {
            return $query->whereIn('status_matrix_id', $status_matrix_id);
        }
    }
}
