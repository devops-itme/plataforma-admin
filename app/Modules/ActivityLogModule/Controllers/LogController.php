<?php

namespace App\Modules\ActivityLogModule\Controllers;

use App\Modules\ActivityLogModule\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $path = 'ActivityLogModule.views.html.';

    public function index()
    {
        $logs = ActivityLog::get();
        return view($this->path . 'logs', compact('logs'));
    }
}
