<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use App\Models\GuestUser;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\AppUser;
use DB;
use Validator;

class SettingController extends Controller
{

    public function index()
    {

        $settings = Setting::first();
        
        $response = array();
        $response['success'] = 'Success';
        $response['error'] =    NULL;
        $response['data'] = $settings;
        return response()->json($response);
    }
   
}
