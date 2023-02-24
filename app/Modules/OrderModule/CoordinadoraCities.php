<?php

namespace App\Modules\OrderModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use App\Modules\OrderModule\CoordinadoraOrderDetail;
use App\Modules\OrderModule\Order;

class CoordinadoraCities extends Model
{
    use RestActions, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coordinadora_cities';

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

}
