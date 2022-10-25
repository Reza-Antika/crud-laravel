<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function result($message='', $status=false, $data=null){
        $result=[
            "status" => $status,
            "data" => $data,
            "message"=> $message,
            "newToken" => csrf_token()
    ];
    return response()->json($result);

    }
}
