<?php

namespace App\Modules\StatusMatrixModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\RoleModule\Role;
use App\Modules\StatusMatrixModule\StatusMatrix;
class StatusMatrixController extends Controller
{

    protected $path = 'StatusMatrixModule.views.html.';

    public function index()
    {
        $statusMatrix = StatusMatrix::with('getScope')->get();
        $roles = Role::get();
        return view($this->path . 'index', compact('statusMatrix', 'roles'));
    }

    public function statusMatrix()
    {

    }
}
