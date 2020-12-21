<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    public function saveDeviceToken(Request $request)
    {
        dd($request->all());
    }
}
