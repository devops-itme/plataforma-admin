<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\DB;
use App\Modules\GuideModule\TealcaData;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Http\Request;

trait TealcaByGuide
{
    public function updateTealcaDataByGuide()
    {    
        $Tealca = new Tealca();
        $Tealca->login();

        $query = DB::table('guides as g')
        ->select('g.id', 'g.order_id','g.status_matrix_id', 'g.external_id as external_id', 'g.contact as contact', 'g.created_at as AppEventDate')
        ->where('g.external_id', '<>', null)
        ->where('g.country', '<>', 'PAN')
        ->join('orders as o', 'o.id', '=', 'g.order_id')
        ->where('o.deleted_at', null)
        ->whereNotBetween('o.id', [277,349])
        ->where('g.created_at','>=', DB::raw('DATE_SUB(NOW(), INTERVAL 10 DAY)'))
        ->get();

        //dd($query);
        //return $query;
        foreach ($query as $guide) {

            $guideTracking = $Tealca->requestOrderStatus($guide->external_id);
            $guide->Status = 'NCT';
            $guide->FechaTime = '0000-00-00';
            $guide->historical = ['No consultado'];

            if (
                $guideTracking['state'] != 500
                && isset($guideTracking['data'][0]['tracking'])
                && is_array($guideTracking['data'][0]['tracking'])
                && count($guideTracking['data'][0]['tracking']) > 0
            ) {

                foreach ($guideTracking['data'][0]['tracking'] as $tracking) {
                    switch ($tracking['status']) {
                        case 'Creacion':
                            $guide->Status = 'VERIFICACION';
                            $guide->FechaTime = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $guide->historical[] = $tracking;
                            break;

                        case 'Recepcion desde plataforma':
                            $guide->Status = 'RECEPTADO A BODEGA';
                            $guide->FechaTime = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $guide->historical[] = $tracking;
                            break;

                        case 'Recepcion desde tienda':
                            $guide->Status = 'RECEPCION EN SUCURSAL';
                            $guide->FechaTime = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $guide->historical[] = $tracking;
                            break;

                        case 'Despacho a tienda(tienda destino para entrega al cliente)':
                            $guide->Status = 'DESPACHO A SUCURSAL';
                            $guide->FechaTime = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $guide->historical[] = $tracking;
                            break;

                        default:
                            $guide->Status = $tracking['status'];
                            $guide->FechaTime = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $guide->historical[] = $tracking;
                    }
                    break;
                }
            }

            $guide->action = '<a href="javascript:;" class="ml-2 details" name="details" data-toggle="modal" (click)="open()" data-target="#myModal" data-placement="left" title="Detalles" id="' . $guide->external_id . '"><i class="fa fa-eye fa-lg text-info" aria-hidden="true"></i></a>';

            $request = new Request(array(
                'id' => $guide->id,
                'order_id' => $guide->order_id,
                'external_id' => $guide->external_id,
                'contact' => $guide->contact,
                'date_status' => $guide->FechaTime,
                'status' => $guide->Status,
                'historical' => current($guide->historical),
                'action' => $guide->action,
            ));

            $tealca = new TealcaData();
            $saveTealca = $tealca->saveTealca($request);
            
        }
        
        return 'Tealca datas updated';
    }
}
