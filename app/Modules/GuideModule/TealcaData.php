<?php

namespace App\Modules\GuideModule;

use App\Http\Controllers\Traits\RestActions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Support\Facades\DB;

class TealcaData extends Model
{
    use SoftDeletes, LogsActivity, RestActions;

    protected $table = 'tealca_datas';
    protected $fillable = [

        'guide_id',
        'order_id' ,
        'external_id',
        'contact',
        'date_status',
        'status',
        'historical',
        'action',
    ];

    /* Logs Config */


    /*End logs config */

    // Scopes


    public function validateGuide($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id' => 'required',
                'order_id' => 'required',
                'external_id' => 'required',
                'contact' => 'required',
                'date_status' => 'required',
                'status' => 'required',
                'action' => 'required',
            ]
        );
    }

    public function saveTealca($request)
    {
        try {

            $tealca = TealcaData::updateOrCreate(
                [
                    'guide_id' => $request->guide_id,
                ],
                [
                    'guide_id' => $request->guide_id,
                    'order_id' => $request->order_id,
                    'external_id' => $request->external_id,
                    'contact' => $request->contact,
                    'date_status' => $request->date_status,
                    'status' => $request->status,
                    'historical' => json_encode($request->historical),
                ]
            );

            return $this->respond(200, null, null, 'creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear');
        }
    }
}
