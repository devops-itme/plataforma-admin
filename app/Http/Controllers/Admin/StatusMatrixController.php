<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\StatusMatrix;
use Illuminate\Http\Request;

class StatusMatrixController extends Controller
{
    public function index()
    {
        $statusMatrix = StatusMatrix::with('getScope')->get();
        $roles = Role::get();
        return view('statusMatrix.index', compact('statusMatrix', 'roles'));
    }

    public function statusMatrix()
    {

    }
}
