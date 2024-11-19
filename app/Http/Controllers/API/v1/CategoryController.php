<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::where('status','yes')->orderBy('ordering','asc')->get();

        $categories->map(function($category){
            if(!empty($category->photo)){
                $category->photo = asset('images/category/'.$category->photo);
            }
            return $category;
        });
        
        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $categories;

        return response()->json($response);
    }
}
