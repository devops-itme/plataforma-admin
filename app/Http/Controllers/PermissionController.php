<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        return view('permits', compact('roles'));
    }
}
