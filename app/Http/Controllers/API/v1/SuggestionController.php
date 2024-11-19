<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;

class SuggestionController extends Controller
{

    public function index()
    {
        $suggestions = Suggestion::where('status','yes')->get();
        
        $response = array();
        $response['success'] = 'Success';
        $response['error'] =    NULL;
        $response['data'] = $suggestions;
        return response()->json($response);
    }

    public function ByCategpry($id)
    {
        $response = array();
        
        $suggestions = Suggestion::where('category_id',$id)->where('status','yes')->get();
        $response['success'] = 'Success';
        $response['error'] =    NULL;
        $response['data'] = $suggestions;
        
        return response()->json($response);
    }
}
