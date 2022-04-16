<?php

namespace App\Modules\ParametersModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ParametersModule\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    protected $path = 'ParametersModule.views.html.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Parameter::get();
        return view($this->path . 'index', compact('parameters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
}
