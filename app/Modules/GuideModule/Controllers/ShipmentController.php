<?php

namespace App\Modules\GuideModule\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuideModule\Guide;
use App\Modules\ApiConnectionsModule\Imports\ShipmentTealcaImport;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\OrderModule\CoordinadoraOrderDetail;
use App\Modules\OrderModule\Order;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CoordinadoraGuidesExport;
use App\Modules\OrderModule\CoordinadoraCities;
use App\Exports\CoordinadoraGuidesTemplate;
use App\Modules\ApiConnectionsModule\Models\Coordinadora;

class ShipmentController extends Controller
{
    use RestActions, GuideTrait;
    protected $path = 'GuideModule.views.html.shipments.';
    protected $CoordPath = 'GuideModule.views.html.coordinadora.';

    public function index(Request $request)
    {
        $order_id = 'order_id';
        $order_id = $request->order_id;
        $Guide = new Guide();
        $Coordinadora = new CoordinadoraOrder();
        $isCoordinadora = $this->isCoordinadoraBatch($order_id);
        
        if (!is_null($isCoordinadora)) {
            $guides = $Coordinadora->getCoordinadoraGuidesByOrder($order_id)['data'];
            
            return view($this->CoordPath . 'index', compact('guides', 'order_id'));
        }

        $response = $Guide->getGuidesByOrder($order_id, (request()->pagination ?? 15));
        if ($response['state'] != 200) {
            return redirect()->back()->with('warning', 'Orden no encontrada');
        };
        $shipments = $response['data'];
        return view($this->path . 'index', compact('shipments', 'order_id'));
    }

    public function sendBatch($id)
    {   
        //set_time_limit(3600);
        $Guide = new Guide();
        $Tealca = new Tealca();
        $Tealca->login();
        $guideResponse = $Guide->getGuidesByOrder($id, false);
        if ($guideResponse['state'] != 200) {
            return $guideResponse;
        }
        $guides = $guideResponse['data'];
        
        foreach ($guides as $guide) {
            if ($guide->external_id != NULL) {
                continue;
            }
            $response = $Tealca->requestCreateShipment($guide);
            if ($response['state'] != 200) {
                return redirect()->back()->with('danger', $response['message']);
            }
        }
        return redirect()->route('shipments.index', ['order_id' => $id])->with('success', 'Lote subido correctamente');
    }
    public function create(Request $request)
    {
        $order_id = $request->order_id;
        $Tealca = new Tealca();
        $Tealca->login();
        $destination = $Tealca->getDestination();
        //dd($destination);
        $tiendas=$Tealca->getTiendas();
        /* $tienda = $tiendas['data']; */
        //dd($tienda);
        return view($this->path . 'create', compact('order_id','destination','tiendas'));
    }

    public function store(Request $request)
    {

        /* $validated = $request->validate([
            'recipient_name' => 'required|max:40',
            'address_name' => 'required|max:35',
        ]); */
        $response = $this->storeGuide($request);
        //este no es
        /* dd($response); */
        if ($response['state'] = 200) {
            return redirect()->route('shipments.index', ['order_id' => $request->order_id])->with('success', $response['message']);
        }
        return redirect()->back()->with('danger', $response['message']);
    }

    public function edit($id)
    {


        $guide = Guide::find($id);
        $id_branch_office = $guide['branch_office'];

        $Tealca = new Tealca();
        $Tealca->login();
        $destination = $Tealca->getDestination();
        

        $tiendas=$Tealca->getTiendas();

        if ($id_branch_office == null) {
            $branch = new BranchOffice();
            $branch->name = 'Sin seleccionar';
        } else {
            $branch = BranchOffice::find($id_branch_office);
        }

        return view($this->path . 'edit', compact('guide', 'branch','destination', 'tiendas'));
    }

    public function update(Request $request, $id)
    {   
        $dato_guide = Guide::find($id);
        $order_id = $dato_guide->order_id;
        $findGuideNumber = Guide::where('external_id', $request->guideNumber)->get();
        //dd($findGuideNumber);
        if (count($findGuideNumber) > 0) {
            return redirect()->route('shipments.index', ['order_id' => $order_id])->with('danger', 'Error: el número de guía indicado ya existe. Porfavor verifique e intente nuevamente');
        }

        $request->guide_id = $id;
        $response = $this->updateGuide($request);

        if ($response['state'] = 200) {
            return redirect()->route('shipments.index', ['order_id' => $order_id])->with('success', 'Guia actualizada exitosamente.');
        }
        return redirect()->back()->with('danger', $response['message']);
    }

    public function show($id){

        $guide = Guide::find($id);
        $Tealca = new Tealca();
        $Tealca->login();

        $history = $Tealca->requestOrderStatus($guide->external_id);
        if($history['data'] == null){
            $history['state']=500;
            return view($this->path. 'show', compact('guide','history'));
        }else{
            $info = $history['data'][0]['tracking'];
            return view($this->path. 'show', compact('guide', 'history', 'info'));
        }

    }

    public function isCoordinadoraBatch($order_id)
    {
        $findBatch = Order::where('id', $order_id)->where('description', '<>', null)->get()->first();
        return $findBatch;
    }

    public function coordinadoraGuideDetails($order_id)
    {
        $Coordinadora = new CoordinadoraOrder();
        $CoordinadoraDetails = new CoordinadoraOrderDetail();
        $order = $Coordinadora->getCoordinadoraGuide($order_id)['data'];
        $orderDetails = $CoordinadoraDetails->getGuideProducts($order_id)['data'];
        
        return view($this->CoordPath. 'showGuideDetail', compact('order', 'orderDetails'));
    }

    public function coordinadoraCreateGuideView($order_id)
    {   
        
        $cities = CoordinadoraCities::all();
        return view($this->CoordPath. 'create', ['order_id' => $order_id, 'cities'=> $cities]);
    }

    public function coordinadoraAddGuide(Request $request)
    {   
        
        $Coordinadora = new CoordinadoraOrder();
        $storeGuidePetition = $Coordinadora->addGuideToBatch($request);
        
        //dd($storeGuidePetition);
        if ($storeGuidePetition['state'] == 201) {
            return redirect()->route('shipments.index', ['order_id' => $request->order_id])->with('success', $storeGuidePetition['message']);
        }
        if ($storeGuidePetition['state'] == 500) {
            
            return redirect()->back()->with('danger', $storeGuidePetition['error']);
        }
        
    }

    public function coordinadoraEditGuide($id)
    {   
        $orderDetails = new CoordinadoraOrderDetail();
        $guide = CoordinadoraOrder::find($id);
        $guideDetails = $orderDetails->getGuideProducts($id)['data'];
        $order_id = $guide->id;
        $cities = CoordinadoraCities::all();
        return view($this->CoordPath. 'editGuideDetail', compact('guide', 'order_id', 'guideDetails', 'cities'));
    }

    public function coordinadoraUpdateGuide(Request $request, $order_id)
    {
        $Coordinadora = new CoordinadoraOrder();
        $updateGuidePetition = $Coordinadora->updateCoordinadoraGuide($request, $order_id);
        $findGuide = CoordinadoraOrderDetail::find($order_id);
        $guide_id = $findGuide->guide_id;

        $guide = $Coordinadora::find($guide_id);        
        $batch_id = $guide->order_id;
        
        //dd($updateGuidePetition);
        if ($updateGuidePetition['state'] == 200) {
            return redirect()->route('shipments.index', ['order_id' => $batch_id])->with('success', $updateGuidePetition['message']);
        }
        if ($updateGuidePetition['state'] == 500) {
            
            return redirect()->back()->with('success', $updateGuidePetition['error']);
        }
    }

    public function coordinadoraDeleteGuide($id)
    {
        $Coordinadora = new CoordinadoraOrder();
        $guide = $Coordinadora::find($id);
        $order_id = $guide->id ?? null;
        $deleteGuidePetition = $Coordinadora->deleteCoordinadoraGuide($id);

        
        if ($response['state'] = 200) {
            return redirect()->route('shipments.index', ['order_id' => $order_id])->with('success', $deleteGuidePetition['message']);
        }
        return redirect()->back()->with('danger', $response['message']);
    }

    public function coordinadoraDeleteProduct($id)
    {
        $Coordinadora = new CoordinadoraOrderDetail();
        $product = $Coordinadora::find($id);
        $order_id = $product->guide_id;
        $deleteProductPetition = $Coordinadora->deleteProduct($id);

        dd($deleteProductPetition);
        if ($response['state'] = 200) {
            return redirect()->back()->with('success', "Producto eliminado");
        }
        return redirect()->back()->with('danger', $response['message']);
    }

    public function coordinadoraAddProduct(Request $request)
    {
        $Coordinadora = new CoordinadoraOrderDetail();
        $guide_id = $request->guide_id;
        $addProductPetition = $Coordinadora->createProduct($request, $guide_id);

        dd($addProductPetition);
        if ($addProductPetition['state'] == 201) {
            return redirect()->back()->with('success', "Producto añadido");
        }
        return redirect()->back()->with('danger', $addProductPetition['error']);
    }

    public function coordinadoraGuidesExport($order_id)
    {   
        $CoordinadoraOrder = new CoordinadoraOrder();
        $updateGuidesStatus = $CoordinadoraOrder->updateGuideStatus($order_id);
        
        
        $batchData = Order::find($order_id);
        $guidesData = $CoordinadoraOrder->getAllGuideAndDetails($order_id)['data'];
        return Excel::download(new CoordinadoraGuidesExport($guidesData, $batchData), 'reporteDeGuiasCoordinadora.xlsx');
   
    }

    public function coordinadoraGuidesTemplate()
    {
        return Excel::download(new CoordinadoraGuidesTemplate(), 'PlantillaDeGuiasCoordinadora.xlsx');
    }

    public function getDestinationTealca(){

        $Tealca = new Tealca();
        $Tealca->login();

        $destination = $Tealca->getDestination();

        return $this->respond(200, $destination, null, 'Destinos tealca');
    }

    public function getTiendasTealca(){

        $Tealca = new Tealca();
        $Tealca->login();
        
        $tiendas = $Tealca->getTiendas();

        return $this->respond(200, $tiendas, null, 'Tiendas tealca');
    }
}
