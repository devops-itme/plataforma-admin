<?php

namespace App\Modules\OrderModule\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Modules\AddressModule\Address;
use App\Modules\AddressModule\Controllers\AddressTrait;
use App\Modules\GuideModule\Controllers\GuideTrait;
use App\Modules\OrderModule\Controllers\OrderTrait;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
use App\Modules\GuideModule\Guide;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternationalOrderController extends Controller
{
    use OrderTrait, GuideTrait, AddressTrait;

    public function respond($state, $data = [], $error = null, $message = '')
    {
        return [
            'state' => $state, //response status
            'data' => $data, //response data
            'error' => $error, //bug for developer
            'message' => $message //user message
        ];
    }

    protected $customerRelationships = [
        'getOrderType', 'getDocumentType', 'getPaymentMethod',
        'getState', 'getDepartment', 'getBranchOffice',
        'getScheduleTime', 'getScheduleTime.getDay'
    ];

    protected $messengerRelationships = [
        'getUser', 'getUser.getDocumentType',
        'getOrderType', 'getDocumentType', 'getPaymentMethod',
        'getState', 'getDepartment', 'getBranchOffice',
        'getScheduleTime', 'getScheduleTime.getDay'
    ];

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $role_name = $request->role_name ?? Auth::user()->getRole->name;
        $scope_name = $request->scope_name ?? [];
        $status_matrix = $request->status_matrix ?? [];
        $order_type = "International";
        $orders = [];

        try {
            $status_matrix = StatusMatrix::whereIn('name', $status_matrix)->get(['id']);
            count($status_matrix) == 0 && $status_matrix = null;

            $scopes = ParameterValue::whereIn('name', $scope_name)->get(['id']);
            $status = StatusMatrix::whereIn('scope_id', $scopes)->get(['id']);
            count($status) == 0 && $status = null;

            if ($role_name == 'Admin') {
                // $orders = Order::where('user_id', $user_id)
                $orders = Order::whereStatusMatrix($status_matrix)
                    ->where('user_id', $user_id)
                    ->whereStatusMatrix($status)
                    ->international($order_type)
                    ->with($this->customerRelationships)->get();
            }

            if ($role_name == 'Cliente') {
                // $orders = Order::where('user_id', $user_id)
                $orders = Order::whereStatusMatrix($status_matrix)
                    ->where('user_id', $user_id)
                    ->whereStatusMatrix($status)
                    ->international($order_type)
                    ->with($this->customerRelationships)->get();
            }

            $orders = OrderResource::collection($orders);
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function show($order_id)
    {
        $order_type = "International";
        try {
            $order = Order::find($order_id)->where('order_type', $order_type)->get();
            $order = OrderResource::collection([$order])[0];
            return $this->respond(200, $order, null, 'Detalle de la orden');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function store(Request $request)
    {
        try {

            // $validator = $this->GuideValidate($request);

            $validator = Validator::make(
                $request->all(),
                [
                    // 'order_id' => [$action == 'create' ? 'confirmed' : 'nullable',
                    //         Rule::requiredIf($action == 'create'), 'exists:orders,id'
                    // ],
                    'order_id' => 'nullable',
                    'branch_office' => 'nullable',
                    'transport_type' => 'nullable',
                    'dispatched' => 'nullable',
                    'address_id' => 'nullable',
                    'address_name' => 'required|string|max:200',
                    'address_lat' => 'nullable',
                    'address_lng' => 'nullable',
                    'address_description' => 'nullable',
                    'zone' => 'nullable',
                    // 'country' => 'required|string|size:2',
                    'city' => 'required|string|size:3',
                    'recipient_name' => 'required|string|max:100',
                    'document_type' => 'required|string',
                    'document' => 'required|numeric|digits_between:1,15',
                    'delivery_office' => 'required|string|max:100',
                    'pre_guide' => 'required|numeric|digits_between:1,20',
                    'invoice_number' => 'required|alpha_num',
                    'declared' => 'required|numeric',
                    'pieces' => 'required|numeric',
                    'kg' => 'required|numeric',
                    'concept' => 'nullable',
                    'rate' => 'nullable',
                    'value' => 'nullable',
                    'corp_value' => 'nullable',
                    'customer_document_type' => 'nullable',
                    'contact' => 'required|string|max:20',
                    'phone_contact' => 'required|numeric|digits_between:1,11',
                    'email_contact' => 'required|email|max:75',
                    'invoice_contact' => 'nullable',
                    'same_day_delivery' => 'nullable',
                    'sign' => 'nullable',
                    'take_photo' => 'nullable',
                    'packaging' => 'nullable',
                    'return_last_destination' => 'nullable',
                    'description' => 'nullable|max:150',

                    //EMPTY TEALCA FIELDS
                    'UserLogin' => 'required|string',
                    'DeclaratedValueCurrency' => 'required|string|max:3',
                    'DeclaratedValueInvoceNum' => 'nullable|string|max:20',
                    'IsSafeKeeping' => 'required',
                    'CustomerCode' => 'required|string|max:10',
                    'BUCodeSource' => 'required|string|max:3',
                    'BUCodeConsignee' => 'nullable|string|max:3',
                    'ConsigneeCountry' => 'required|string|size:2',
                    'ConsigneePhoneCode' => 'required|numeric|digits_between:1,3',
                    'EmailType' => 'required|numeric|size:020',
                    'ConsigneeTaxIdentTypeCode' => 'required|string|max:10',
                    'ShipperCountry' => 'required|string|size:2',
                    'ShipperCity' => 'required|string|size:3',
                    'ShipperAddress' => 'nullable|string|max:200',
                    'ShippingMethodID' => 'required|numeric|size:10',
                    'ShipperIdentification' => 'required|numeric|digits_between:1,15',
                    'ShipperName' => 'required|max:100',
                    'ShipperPhoneCode' => 'required|numeric|digits_between:1,3',
                    'ShipperPhone' => 'required|numeric|digits_between:1,11',
                    'ShipperTaxIdentTypeCode' => 'required|max:10',
                    'DeliveryTypeID' => 'required|numeric|size:10',
                    'MeasureUnitTypeID' => 'required|numeric',
                    'WeightUnitID' => 'required|numeric',
                    'PackageTypeID' => 'required|numeric|size:10',
                    'ShipperPostalCode' => 'required|string|max:12',
                    'ShipperAddressLine2' => 'nullable',
                    'ConsigneePostalCode' => 'nullable|numeric|digits_between:1,12',
                    'ConsigneeAddressLine2' => 'nullable|string|max:200',
                    'ShipmentDetailReference' => 'nullable|string|max:100',
                    'ProductCode' => 'nullable|string|max:250',
                    'Lenght' => 'nullable|numeric',
                    'Width' => 'nullable|numeric',
                    'Height' => 'nullable|numeric',
                    'ConsigneeEmail' => 'required|email|max:75',
                ]
            );


            if ($validator->fails()) {
                return $this->respond(400, null, $validator->errors(), "Solicitud incorrecta");
            }

            $user_id = $request->user_id;
            $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
            $order = Order::where('order_type', $order_type)->latest()->first(['id', 'order_number']);
            $lot_number = 'Lote_1';
            if (!is_null($order)) {
                $last_batch = explode('_', $order->order_number)[1];
                $lot_number = 'Lote_' . ($last_batch + 1);
            }

            DB::beginTransaction();
            $orderResponse = $this->storeOrder(new Request(array(
                'user_id' => Auth::user()->id,
                'guides' => json_decode($request->guides),
                'order_number' => $lot_number,
                'order_type' => $order_type,
                'creator_user_id' => Auth::user()->id,
            )));

            $order_id = $orderResponse['data']['id'];

            $Order = Guide::create([
                'order_id' => $order_id,
                'description' => $request->description,
                'branch_office' => $request->branch_office,
                'transport_type' => $request->transport_type,
                'dispatched' => $request->dispatched,
                "address_id" => $request->address_id,
                'address_name' => $request->address_name,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
                'address_description' => $request->address_description,
                'detail_package' => $request->detail_package,
                'zone' => $request->zone,
                'country' => $request->country,
                'city' => $request->city,
                'recipient_name' => $request->recipient_name,
                'document_type' => $request->document_type,
                'document' => $request->document,
                'delivery_office' => $request->delivery_office,
                'pre_guide' => $request->pre_guide,
                'invoice_number' => $request->invoice_number,
                'declared' => $request->declared,
                'pieces' => $request->pieces,
                'kg' => $request->kg,
                'concept' => $request->concept,
                'rate' => $request->rate,
                'value' => $request->value,
                'corp_value' => $request->corp_value,
                'customer_document_type' => $request->customer_document_type,
                'contact' => $request->contact,
                'phone_contact' => $request->phone_contact,
                'email_contact' => $request->email_contact,
                'invoice_contact' => $request->invoice_contact,
                'same_day_delivery' => $request->same_day_delivery,
                'sign' => $request->sign,
                'take_photo' => $request->take_photo,
                'packaging' => $request->packaging,
                'return_last_destination' => $request->return_last_destination,
                'boxes' => $request->boxes
            ]);
            DB::commit();

            $Guide = new Guide();
            $Tealca = new Tealca();
            $Tealca->login();
            $guideResponse = $Guide->getGuidesByOrder($order_id, false);
            if ($guideResponse['state'] != 200) {
                return $guideResponse;
            }
            $guides = $guideResponse['data'];
            foreach ($guides as $guide) {
                if ($guide->external_id != NULL) {
                    continue;
                }
                $response = $Tealca->requestCreateShipment($guide);
                if ($response['state'] == 200) {
                    return $this->respond(200, $response['data'], null, 'OK');
                }
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge(['order_id' => $id]);
            return $orderResponse = $this->updateOrder($request);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
        }
    }
}
