<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class BannerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Banner::select('*');
        
        if($request->search != null){
            $query->where('name','like','%'.$request->search.'%');
        }
        
        $banners=  $query->paginate(10);
        
        return view("banners.index")->with('banners',$banners);
    }

    public function create()
    {

        return view("banners.create");
    }

   public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), $rules = [
            'name' => 'required',
            'photo' => 'required',
        ], $messages = [
            'name.required' => 'The  Name field is required!',
            'photo.required' => 'The  photo field is required!',
        ]);

        if ($validator->fails()) {
            return redirect('banners/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $data=$request->all();
       
        if ($request->hasfile('photo')) {
            $destination = public_path('images/banners/'. $data['photo']);
            if(File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move(public_path('images/banners/'), $filename);
            $data['photo']=$filename;
            
        }
        Banner::create([
            'name' => $request->get('name'),
            'photo' => $data['photo'],
            'status' => ($request->get('status') == "on") ? 'yes' : 'no',
        ]);
        
        return redirect('banners')->with('message','Banner successfully created');

    }

    public function edit($id)
    {
        $banners = Banner::where('id', "=", $id)->first();

        return view("banners.edit")->with("banners", $banners);
    }

    public function update(Request $request, $id)
    {

        if ($id > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
        }else{
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        
        $validator = Validator::make($request->all(), $rules = [
            'name' => 'required',
            'photo' =>$image_validation,
        ], $messages = [
            'name.required' => 'The  Name field is required!',
            'photo.required' => 'The  photo field is required!',

        ]);

        if ($validator->fails()) {
            return redirect('banners/edit/'.$id)
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $name = $request->input('name');
        $status = $request->has('status') ? 'yes' : 'no';

        $banners = Banner::find($id);
        
        if ($banners) {
            $banners->name = $name;
            $banners->status = $status;
            $banners->updated_at = date('Y-m-d H:i:s');
            $banners->name = $request->input('name');

            if ($request->hasfile('photo')) {
                $destination = public_path('images/banners/'.$banners->photo);
                if(File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move(public_path('images/banners/'), $filename);
               
                $banners->photo = $filename;
            }

            $banners->save();
        }

        return redirect('banners')->with('message','Banner successfully updated');
    }

    public function status(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $banners = Banner::find($id);
        $banners->status = ($ischeck == "true")?'yes':'no';
        $banners->save();

    }

    public function delete($id)
    {
       
        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {
               
                for ($i = 0; $i < count($id); $i++) {
                   
                    $banners = Banner::find($id[$i]);
                    $banners->delete();
                }

            } else {
                $banners = Banner::find($id);
                $banners->delete();
            }

        }

        return redirect('banners')->with('message','Banner successfully deleted');
    }

}