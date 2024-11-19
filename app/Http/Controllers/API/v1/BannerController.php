<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index(Request $request)
    {
        $banners = Banner::where('status','yes')->get();

        $banners->map(function($banner){
            if(!empty($banner->photo)){
                $banner->photo = asset('images/banners/'.$banner->photo);
            }
            return $banner;
        });
        
        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $banners;

        return response()->json($response);
    }
}
