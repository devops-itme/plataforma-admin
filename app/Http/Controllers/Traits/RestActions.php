<?php

namespace App\Http\Controllers\Traits;

trait RestActions
{
    public function respond($state, $data = [], $error = null, $message = '')
    {
        return [
            'state' => $state, //response status
            'data' => $data, //response data
            'error' => $error, //bug for developer
            'message' => $message //user message
        ];
    }
}
