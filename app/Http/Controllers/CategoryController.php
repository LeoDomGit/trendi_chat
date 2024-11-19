<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Category::select('*');
        
        if($request->search != null){
            $query->where('name','like','%'.$request->search.'%');
        }
        
        $categories=  $query->orderBy('ordering','asc')->paginate(10);

        return view("categories.index")->with('categories',$categories);
    }

    public function create()
    {

        return view("categories.create");
    }

   public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'photo' => 'required',
        ]);

        if($validator->fails()){
            return redirect('categories/create')->withErrors($validator)->withInput();
        }

        $data = $request->all();
       
        if ($request->hasfile('photo')) {
            $destination = public_path('images/category/'. $data['photo']);
            if(File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move(public_path('images/category/'), $filename);
            $data['photo']=$filename;
        }
        
        Category::create([
            'name' =>  $data['name'],
            'photo' => $data['photo'],
            'status' => ($request->get('status') == "on") ? 'yes' : 'no',
            'ordering' => $data['ordering'] ? : 0,
        ]);
        
        return redirect('categories')->with('message','Category successfully created');;

    }

    public function edit($id)
    {
        $category = Category::where('id', "=", $id)->first();

        return view("categories.edit")->with("category", $category);
    }

    public function update(Request $request, $id)
    {

        if ($id > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
        }else{
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'photo' =>$image_validation,
        ]);

        if ($validator->fails()) {
            return redirect('categories/edit/'.$id)->withErrors($validator)->withInput();
        }
        
        $category = Category::find($id);
        
        if ($category) {

            $category->name = $request->input('name');
            $category->status = ($request->input('status') == "on")?'yes':'no';
            $category->ordering = $request->input('ordering');
            
            if ($request->hasfile('photo')) {
                $destination = public_path('images/category/'.$category->photo);
                if(File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move(public_path('images/category/'), $filename);
               
                $category->photo = $filename;
            }

            $category->save();
        }

        return redirect('categories')->with('message','Category successfully updated');;
    }
    
    public function status(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $category = Category::find($id);

        if ($ischeck == "true") {
            $category->status = 'yes';
        } else {
            $category->status = 'no';
        }
        $category->save();

    }

    public function delete($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $categories = Category::find($id[$i]);
                    $categories->delete();
                }

            } else {
                $categories = Category::find($id);
                $categories->delete();
            }

        }

        return redirect('categories')->with('message','Category successfully deleted');;
    }

}