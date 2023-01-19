<?php

namespace App\Modules\ApiConnectionsModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ApiConnectionsModule\Models\ApiSync;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;


class ApiSyncController extends Controller
{
    use RestActions;
    protected $path = 'ActivityLogModule.views.html.';
    protected $ApiSync;

    public function __construct()
    {
        $this->ApiSync = new ApiSync;
    }

    public function index(Request $request)
    {   
        
        $logsQuery = $this->ApiSync->apiGetLogs()['data']['data'];
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($logsQuery);
        $perPage = 15;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());

        $logs = $paginatedItems;
        return view($this->path . 'apiSync', compact('logs'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}