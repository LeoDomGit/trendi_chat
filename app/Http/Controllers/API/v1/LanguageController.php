<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function index(Request $request)
    {
        $languages = language::where('status','yes')->get();

        $languages->map(function($language){
            if(!empty($language->photo)){
                $language->photo = asset('images/languages/'.$language->photo);
            }
            return $language;
        });
        
        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $languages;

        return response()->json($response);
    }
}
