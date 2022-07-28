<?php

namespace App\Modules\GuideModule;

use App\Http\Controllers\Traits\RestActions;
use App\Http\Resources\GuideResource;
use App\Modules\AddressModule\Address;
use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\GuideLogModule\GuideLog;
use App\Modules\OrderModule\Order;
use App\Modules\ZoneModule\Zone;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RouteModule\Route;
use App\Modules\StatusDescriptorModule\StatusDescriptor;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Support\Facades\DB;

class Guide extends Model
{
    use SoftDeletes, LogsActivity, RestActions;

    protected $table = 'guides';
    protected $fillable = [
        'order_id',
        'external_id',
        'branch_office',
        'transport_type',
        'dispatched',
        'address_id',
        'address_name',
        'address_lat',
        'address_lng',
        'address_description',
        'description',
        'zone',
        'country',
        'city',
        'recipient_name',
        'document_type',
        'document',
        'delivery_office',
        'pre_guide',
        'invoice_number',
        'declared',
        'pieces',
        'kg',
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
        'issue',
        'additional_address',
        'additional_email',
        'additional_phone',
        'novelty',
        'detail_package'
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;
    protected static $logOnlyDirty  = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = "Se ha " . __($eventName) . " la guía N°" . $activity->subject->id;
        }
        if ($eventName == 'updated') {
            $this->eventHandler($activity);
            $this->guideLogController($activity);
        }
    }
    /*End logs config */
    public function eventHandler($activity)
    {
        $guide = $activity->subject;
        $guide = GuideResource::collection([$guide])[0];
        $title = 'Cambio de estado';
        $message = 'Cambio de estado';
        $data = [
            'guide' => $guide,
            'notification_type' => 'guide_updated'
        ];
        if (isset($activity->properties['attributes']['status_matrix_id'])) {
            $status_matrix_id = $activity->properties['attributes']['status_matrix_id'];
            $status_matrix = StatusMatrix::find($status_matrix_id);
            $status_descriptor = StatusDescriptor::where('status_matrix_id', $status_matrix_id)->where('role_id', 4)->first();
            if (!is_null($status_descriptor)) {
                $status_matrix->name = $status_descriptor->description;
            }
            $title = 'Cambio de estado';
            $message = 'Estado de la guía N°' . $activity->subject->id . ' actualizado a: ' . $status_matrix->name;
            $data['notification_type'] = 'guide_updated_notification';
            $userToken = $activity->subject->getOrder->getUser->fcm_token ?? Auth::user()->fcm_token ?? '';
            sendCustomNotifications($title, $message, $data, $userToken);
            if($status_matrix->name == 'DESPACHADO') {
                $title = 'Guía asignada';
                $message = 'Se le ha asignado la guía N°' . $activity->subject->id;
            }
        }
        $messengerToken = $activity->subject->getRoute->getMessenger->fcm_token ?? Auth::user()->fcm_token ?? '';
        sendCustomNotifications($title, $message, $data, $messengerToken);
    }

    public function guideLogController($activity)
    {
        if (isset($activity->properties['attributes']['status_matrix_id'])) {
            $status_matrix_id = $activity->properties['attributes']['status_matrix_id'];
            $status_matrix = StatusMatrix::find($status_matrix_id);
            if($status_matrix->name != 'RECOGIDO' || $status_matrix->name != 'ENTREGADO') {
                $request = new Request(array(
                     'status_matrix_id' => $status_matrix_id,
                     'user_id' => Auth()->user()->id,
                     'guide_id' => $activity->subject->id,
                 ));
                 $GuideLog = new GuideLog();
                 $GuideLog->saveGuideLog($request);
            }

        }
    }

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getRoute()
    {
        return $this->hasOne(Route::class, 'guide_id')->orderBy('created_at', 'DESC')->latest();
    }

    public function getStatusMatrix()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
    }

    public function getIssues()
    {
        return $this->hasMany(GuideLog::class, 'guide_id')->whereNotNull('issue_id');
    }

    public function getTransportType()
    {
        return $this->belongsTo(ParameterValue::class, 'transport_type');
    }

    public function getGuideLogs()
    {
        return $this->hasMany(GuideLog::class, 'guide_id');
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
        return $this->hasMany(GuidanceDocument::class, 'guide_id');
    }

    public function getZone()
    {
        return $this->belongsTo(Zone::class, 'zone');
    }

    // Scopes
    public function scopeWhereExternalId($query, $value)
    {
        if (!is_null($value)) {
            return $query->where('external_id', 'like', '%' . $value . '%');
        }
    }
    public function scopeWhereRecipientName($query, $value)
    {
        if (!is_null($value)) {
            return $query->where('recipient_name', 'like', '%' . $value . '%');
        }
    }
    public function scopeWhereContact($query, $value)
    {
        if (!is_null($value)) {
            return $query->where('contact', 'like', '%' . $value . '%');
        }
    }
    public function scopeWhereStatusMatrix($query, $status_matrix_id)
    {
        if (!is_null($status_matrix_id)) {
            return $query->whereIn('status_matrix_id', $status_matrix_id);
        }
    }
    public function scopeDate($query, $from, $to)
    {
        if (!is_null($from) && !is_null($to)) {
            return $query->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]);
        }
    }

    public function validateGuide($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'order_id' => 'nullable|exists:orders,id',
                'branch_office' => 'nullable',
                'transport_type' => 'nullable',
                'dispatched' => 'nullable',
                'address_id' => 'nullable',
                'address_name' => 'required',
                'address_lat' => 'nullable',
                'address_lng' => 'nullable',
                'address_description' => 'nullable',
                'description' => 'required',
                'zone' => 'nullable',
                'country' => 'nullable',
                'city' => 'nullable',
                'recipient_name' => 'nullable',
                'document_type' => 'nullable',
                'document' => 'nullable',
                'delivery_office' => 'nullable',
                'pre_guide' => 'nullable',
                'invoice_number' => 'nullable',
                'declared' => 'nullable',
                'pieces' => 'nullable',
                'kg' => 'nullable',
                'concept' => 'nullable',
                'rate' => 'nullable',
                'value' => 'nullable',
                'corp_value' => 'nullable',
                'customer_document_type' => 'nullable',
                'contact' => 'nullable',
                'phone_contact' => 'nullable',
                'email_contact' => 'nullable',
                'invoice_contact' => 'nullable',
                'same_day_delivery' => 'nullable',
                'sign' => 'nullable',
                'take_photo' => 'nullable',
                'packaging' => 'nullable',
                'return_last_destination' => 'nullable',
            ]
        );
    }

    public function getGuidesByOrder($order_id, $paginate = 10)
    {
        try {
            $guides = $this::whereExternalId(request()->external_id)
                ->whereRecipientName(request()->recipient_name)
                ->whereContact(request()->contact)
                ->date(request()->from, request()->to);

            // dd($guides);
            $guides = $paginate
                ? $guides->where('order_id', $order_id)->paginate($paginate)
                : $guides->where('order_id', $order_id)->get();

            if (is_null($guides)) {
                return $this->respond(500, [], 'guides not founds', 'Error al encontrar guías');
            }
            return $this->respond(200, $guides, null, 'Guías encontradas exitosamente');
        } catch (\Throwable $th) {
            return $this->respond(500, [], $th->getMessage(), 'Error al encontrar guías');
        }
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($guide) { // before delete() method call this
            $guide->getGuideLogs()->delete();
            // do the rest of the cleanup...
        });
    }
}
