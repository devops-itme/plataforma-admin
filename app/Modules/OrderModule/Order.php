<?php

namespace App\Modules\OrderModule;

use App\Http\Controllers\Traits\RestActions;
use App\Http\Resources\OrderResource;
use App\Modules\OrderLogModule\OrderLog;
use App\Modules\AddressModule\Address;
use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\DepartmentModule\Department;
use App\Modules\GuideModule\Guide;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\PickupHourModule\PickupHour;
use App\Modules\StatusDescriptorModule\StatusDescriptor;
use App\Modules\StatusMatrixModule\StatusMatrix;
use App\Modules\UserModule\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use App\Modules\OrderModule\CoordinadoraOrder;

class Order extends Model
{
    use SoftDeletes, LogsActivity, RestActions;

    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'order_type',
        'document_type',
        'order_value',
        'receive_by_COD',
        'internal_product',
        'expenses',
        'diligence_expenses',
        'tax_total',
        'vehicle_type_id',
        'payment_method',
        'user_payment_method',
        'urgent_dispatch',
        'schedule_date',
        'schedule_time',
        'schedule_time_range',
        'insured_value',
        'money_to_collect',
        'percentage_to_collect',
        'customer_user_id',
        'creator_user_id',
        'zone_id',
        'address_id',
        'address_name',
        'address_lat',
        'address_lng',
        'address_description',
        'description',
        'state',
        'service_type',
        'department_id',
        'branch_office',
        'dispatched',
        'app_status',
        'status_matrix_id',
        'paid'
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;
    protected static $logOnlyDirty  = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = ($activity->subject->order_number ?? ('Orden')) . ' ' . "se ha " . __($eventName);
        }
        if ($eventName == 'updated') {
            $this->eventHandler($activity);
        }
    }
    /*End logs config */

    public function eventHandler($activity)
    {
        $order = $activity->subject;
        $order = OrderResource::collection([$order])[0];
        $title = 'Cambio de estado';
        $message = 'Cambio de estado';
        $data = [
            'order' => $order,
            'notification_type' => 'order_updated'
        ];
        if (isset($activity->properties['attributes']['status_matrix_id'])) {
            $status_matrix_id = $activity->properties['attributes']['status_matrix_id'];
            $status_matrix = StatusMatrix::find($status_matrix_id);
            $status_descriptor = StatusDescriptor::where('status_matrix_id', $status_matrix_id)->where('role_id', 4)->first();
            if (!is_null($status_descriptor)) {
                $status_matrix->name = $status_descriptor->description;
            }
            $title = 'Cambio de estado';
            $message = 'Estado de ' . $activity->subject->order_number . ' actualizado a: ' . $status_matrix->name;
            $data['notification_type'] = 'order_updated_notification';
            $userToken = $activity->subject->getUser->fcm_token ?? Auth::user()->fcm_token ?? '';
            // sendCustomNotifications($title, $message, $data, $userToken);
            if($status_matrix->name == 'DESPACHADO') {
                $title = 'Orden asignada';
                $message = 'Se le ha asignado la orden: ' . $activity->subject->order_number;
            }
        }
        $messengerToken = $activity->subject->getGuides[0]->getRoute->getMessenger->fcm_token ?? Auth::user()->fcm_token ?? '';
        sendCustomNotifications($title, $message, $data, $messengerToken);
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function getStatusMatrix()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
    }

    public function getGuides()
    {
        return $this->hasMany(Guide::class, 'order_id');
    }

    public function getCoordinadoraGuides()
    {
        return $this->hasMany(CoordinadoraOrder::class, 'order_id');
    }

    public function getOrderType()
    {
        return $this->belongsTo(ParameterValue::class, 'order_type');
    }

    public function getOrderState()
    {
        return $this->belongsTo(ParameterValue::class, 'state');
    }

    public function getDocumentType()
    {
        return $this->belongsTo(ParameterValue::class, 'document_type');
    }

    public function getPaymentMethod()
    {
        return $this->belongsTo(ParameterValue::class, 'payment_method');
    }

    public function getState()
    {
        return $this->belongsTo(ParameterValue::class, 'state');
    }

    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getScheduleTime()
    {
        return $this->belongsTo(PickupHour::class, 'schedule_time');
    }

    public function getLog()
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }

    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office');
    }

    //SCOPES
    public function scopeWhereCustomer($query, $value)
    {
        if (!is_null($value))
            return $query->where('customer_user_id',  $value);
    }
    public function scopeNumber($query, $value)
    {
        if (!is_null($value))
            return $query->where('order_number', 'like', '%' . $value . '%');
    }
    public function scopeWhereOrderType($query, $value)
    {
        if (!is_null($value))
            return $query->where('order_type', $value);
    }
    public function scopeWhereOrderTypeName($query, $value)
    {
        if (!is_null($value))
            return $query->whereHas('getOrderType', function ($q) use ($value) {
                $q->where('name', 'like', '%' . $value . '%');
            });
    }
    public function scopeCustomer($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function ($q) use ($value) {
                $q->where(DB::raw('concat(name," ",last_name)'), 'like', '%' . $value . '%');
            });
        }
    }
    public function scopeDate($query, $from, $to)
    {
        if (!is_null($from) && !is_null($to)) {
            return $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
    }
    public function scopeState($query, $value)
    {
        if (!is_null($value)) {
            return $query->where('state', $value);
        }
    }
    public function scopeNational($query)
    {
        return $query->whereHas('getOrderType', function ($query) {
            $query->where('name', '<>', 'International');
        });
    }
    public function scopeInternational($query)
    {
        return $query->whereHas('getOrderType', function ($query) {
            $query->where('name', 'International');
        });
    }
    public function scopeMessengerOrders($query, $messenger_user_id)
    {
        if (!is_null($messenger_user_id)) {
            return $query->whereHas('getGuides', function ($query) use ($messenger_user_id) {
                $query->whereHas('getRoute', function ($query) use ($messenger_user_id) {
                    $query->where('messenger_user_id', $messenger_user_id);
                });
            });
        }
    }
    public function scopeWhereStatusMatrix($query, $status_matrix)
    {
        if (!is_null($status_matrix) && is_countable($status_matrix) && $status_matrix[0] != null) {
            return $query->whereIn('status_matrix_id', $status_matrix);
        }
    }


    // Sorting Table Order
    public function scopeSortByOrderNumber($query,$value)
    {
        if (!is_null($value))
            return $query->orderBy('orders.created_at', $value);
    }

    public function scopeSortByOrderType($query,$value)
    {
        if (!is_null($value))
            return $query->orderBy('orders.order_type', $value);
    }

    public function scopeSortByPaidStatus($query,$value)
    {
        if (!is_null($value))
            return $query->orderBy('orders.paid', $value);
    }

    public function scopeSortByUser($query,$value)
    {
        if (!is_null($value)) {
            $query->join('users as u', 'u.id', '=', 'orders.user_id')
                  ->orderBy('u.name', $value);
        }
    }

    public function scopeSortByOrderStatusMatrix($query,$value)
    {
        if (!is_null($value))
            return $query->orderBy('status_matrix_id', $value);
    }

    ////////////////////////

    public function orderValidate($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'order_number' => [
                    $action == 'create' ? 'confirmed' : 'nullable',
                    Rule::requiredIf($action == 'create'), Rule::unique('orders', 'order_number')->ignore($id)->whereNull('deleted_at'), 'string'
                ],
                'user_id' => [Rule::requiredIf($action == 'create'), 'exists:users,id', 'numeric'],
                'zone_id' => 'nullable|exists:zones,id|numeric',
                'order_type' => [Rule::requiredIf($action == 'create'), 'numeric'],
                'order_value' => 'nullable|numeric',
                'receive_by_COD' => 'nullable|numeric',
                'internal_product' => 'nullable|numeric',
                'expenses' => 'nullable|numeric',
                'diligence_expenses' => 'nullable|numeric',
                'tax_total' => 'nullable|numeric',
                'vehicle_type_id' => [Rule::requiredIf($action == 'create'), 'numeric'],
                'payment_method' => 'nullable|numeric',
                'user_payment_method' => 'nullable|numeric',
                'urgent_dispatch' => 'nullable|numeric',
                'schedule_date' => 'nullable',
                'schedule_time' => 'nullable|numeric|exists:pickup_hours,id',
                'schedule_time_range' => [Rule::requiredIf($action == 'create'), 'string'],
                'insured_value' => 'nullable|numeric',
                'money_to_collect' => 'nullable|numeric',
                'percentage_to_collect' => 'nullable|numeric',
                'branch_office' => 'nullable|numeric|exists:branch_offices,id',
                'department_id' => 'nullable|numeric|exists:departments,id',
                'address_id' => 'nullable|numeric|exists:addresses,id',
                'address_name' => 'nullable',
                'address_lat' => 'nullable',
                'address_lng' => 'nullable',
                'address_description' => 'nullable|string',
                'description' => [Rule::requiredIf($action == 'create'), 'string'],
                'state' => 'nullable|numeric'
            ]
        );
    }

    public function showOrder($id)
    {
        try {
            $order = $this::find($id)->load(['getGuides']);
            if (is_null($order)) {
                return $this->respond(500, [], 'order not found', 'Error al encontrar orden');
            }
            return $this->respond(200, $order, null, 'Orden encontrada exitosamente');
        } catch (\Throwable $th) {
            return $this->respond(500, [], $th->getMessage(), 'Error al encontrar orden');
        }
    }

    public function orderStore($request)
    {
        $validator = $this->orderValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        $status = StatusMatrix::get();
        $status_id = $status[0]->id;
        try {
            $order = $this::create([
                'order_number' => $request->order_number,
                'user_id' => $request->user_id,
                'zone_id' => $request->zone_id,
                'order_type' => $request->order_type,
                'order_value' => $request->order_value,
                'receive_by_COD' => $request->receive_by_COD,
                'internal_product' => $request->internal_product,
                'expenses' => $request->expenses,
                'diligence_expenses' => $request->diligence_expenses,
                'tax_total' => $request->tax_total,
                'vehicle_type_id' => $request->vehicle_type_id,
                'payment_method' => $request->payment_method,
                'user_payment_method' => $request->user_payment_method,
                'urgent_dispatch' => $request->urgent_dispatch,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'schedule_time_range' => $request->schedule_time_range,
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect,
                'customer_user_id' => $request->user_id,
                'branch_office'=> $request->branch_office_id,
                'address_id' => $request->address_id,
                'address_name' => $request->address,
                'address_lat' => $request->lat,
                'address_lng' => $request->lng,
                'address_description' => $request->address_description,
                'description' => $request->description,
                'department_id' => $request->department_id,
                'status_matrix_id' => $status_id,
                'creator_user_id' => $request->creator_user_id
            ]);
            return $this->respond(200, $order, null, 'Orden creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear orden');
        }
    }

    public function createOrderWithGuides($request)
    {
        try {
            $validator = $this->orderValidate($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            DB::beginTransaction();
            $status = StatusMatrix::get();
            $status_id = $status[0]->id;
            $order = $this::create([
                'user_id' => $request->user_id,
                'customer_user_id' => $request->user_id,
                'order_type' => $request->order_type,
                'address_id' => $request->address_id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'schedule_date' => $request->schedule_date,
                'schedule_time_range' => $request->schedule_time_range,
                'description' => $request->description,
                'urgent_dispatch' => $request->urgent_dispatch,
                'order_number' => $request->order_number,
                'creator_user_id' => $request->creator_user_id,
                'status_matrix_id' => $status_id,
                'branch_office' => $request->branch_office_id,
                'department_id' => $request->department_id,
                'state' => 1,
            ]);

            foreach ($request->guides as $guide) {
                $data = Guide::create([
                    'order_id' => $order->id,
                    "contact" => $guide->contact,
                    'phone_contact' => $request->phone_contact,
                    'email_contact' => $request->email_contact,
                    "phone_contact" => $guide->phone_contact,
                    "email_contact" => $guide->email_contact,
                    "same_day_delivery" => $guide->same_day_delivery,
                    "sign" => $guide->sign,
                    "take_photo" => $guide->take_photo,
                    "description" => $guide->description,
                    "address_id" => $guide->address_id,
                    "address_name" => $guide->address_name,
                    "address_lat" => $guide->address_lat,
                    "address_lng" => $guide->address_lng,
                    "address_description" => $guide->address_description,
                    'return_last_destination' => $request->return_last_destination,
                    'value' => $guide->value,
                    'corp_value' => $guide->corp_value,
                    'transport_type' => $request->transport_type,
                    'boxes' => json_encode($guide->boxes),
                ]);
            }
            DB::commit();
            return $this->respond(200, $order, null, 'Orden creada exitosamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->respond(500, [], $th->getMessage() . ' ' . $th->getLine(), 'Error al crear orden');
        }
    }

    public function storeOrder($request)
    {   
        
        try {
        
            $order = $this::create([
                'order_number' => $request->order_number,
                'user_id' => $request->user_id ?? 1,
                'order_type' => $request->order_type,
                'customer_user_id' => $request->user_id ?? 1,
                'creator_user_id' => $request->user_id ?? 1,
                'status_matrix_id' => 1
            ]);

            return $this->respond(200, $order, null, 'Orden creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear orden');
        }
    }

    public function generateOrderNumber()
    {
        $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
        //Search Orders
        $orders = Order::where('order_type', '<>', $order_type)->get();
        if (count($orders) > 0) {
            $last_order = $orders[count($orders) - 1]->order_number;
            $order_number = explode('_', $last_order)[1];
            $orderNumber = 'Orden_' . ($order_number + 1);
            return $this->respond(200, $orderNumber);
        } else {
            return $this->respond(500, 'Orden_1');
        }
    }

    public function updateStatusMatrix($id, $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'status_matrix_id' => ['required', is_numeric($request->status_matrix_id) ? 'exists:status_matrix,id' : 'string']
                ]
            );
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            DB::beginTransaction();
            $order = $this::where('id', $id)
                ->whereOrderTypeName('Ondemand')
                ->first();
            $order->update([
                'status_matrix_id' => $request->status_matrix_id
            ]);
            DB::commit();
            return $this->respond(200, $order, null, 'Estado actualizado');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->respond(500, [], $th->getMessage() . ' ' . $th->getLine(), 'Error al actualizar orden');
        }
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function($order) {
            $order->getGuides()->each(function($guides) {
                $guides->getGuideLogs()->delete();
                $guides->delete();
            });
            $order->getCoordinadoraGuides()->delete();
        });
    }
}
