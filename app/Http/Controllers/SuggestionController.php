<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Validator;

class SuggestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Suggestion::join('categories','categories.id','suggestions.category_id');
        
        if($request->search != null){
            $query->orWhere('suggestions.name','like','%'.$request->search.'%');
        }

        if($request->category != null){
            $query->where('suggestions.category_id',$request->category);
        }

        $suggestions=  $query->select('suggestions.*','categories.name as catName')->paginate(10);

        $category=Category::where('status','yes')->get();
                   
        return view("suggestions.index",compact('suggestions','category'));
    }

    public function create()
    {
        $categories = Category::where('status','yes')->get();

        return view("suggestions.create",compact('categories'));

    }

   public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('suggestions/create')->withErrors($validator)->withInput();
        }
     
        Suggestion::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => ($request->get('status') == "on") ? 'yes' : 'no',
        ]);
        return redirect('suggestions')->with('message','Suggestion successfully created');

    }

    public function edit($id)
    {
        $categories = Category::where('status','yes')->get();
        
        $suggestion = Suggestion::find($id);
        
        return view("suggestions.edit",compact('suggestion','categories'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('suggestions/create')->withErrors($validator)->withInput();
        }

        $suggestion = Suggestion::find($id);
        
        if ($suggestion) {
            $suggestion->name = $request->name;
            $suggestion->category_id = $request->category_id;
            $suggestion->status = $request->has('status') ? 'yes' : 'no';
            $suggestion->save();
        }

        return redirect('suggestions')->with('message','Suggestion successfully updated');
    }

    public function status(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $suggestion = Suggestion::find($id);

        if ($ischeck == "true") {
            $suggestion->status = 'yes';
        } else {
            $suggestion->status = 'no';
        }
        $suggestion->save();
    }

    public function delete($id)
    {
        if ($id != "") {
           $id = json_decode($id);
            if (is_array($id)) {
                for ($i = 0; $i < count($id); $i++) {
                    $suggestion = Suggestion::find($id[$i]);
                    $suggestion->delete();
                }
            } else {
                $suggestion = Suggestion::find($id);
                $suggestion->delete();
            }
        }
        return redirect('suggestions')->with('message','Suggestions successfully deleted');
    }
}
