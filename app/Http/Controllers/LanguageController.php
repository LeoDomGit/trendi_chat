<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use App;

class LanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Language::select('*');
        
        if($request->search != null){
            $query->where('name','like','%'.$request->search.'%');
        }
        
        $languages=  $query->paginate(10);
        
        return view("languages.index")->with('languages',$languages);
    }

    public function create()
    {

        return view("languages.create");
    }

   public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'code' => 'required|unique:languages,code',
            'photo' => "required|mimes:jpeg,png,jpg",
        ]);

        if ($validator->fails()) {
            return redirect('languages/create')
                ->withErrors($validator)
                ->withInput();
        }
        $data=$request->all();
       
        if ($request->hasfile('photo')) {
            $destination = public_path('images/languages/'. $data['photo']);
            if(File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            //$filename = time() . '.' . $extenstion;
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images/languages/'), $filename);
            $data['photo']=$filename;
            
        }
        Language::create([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'photo' => $data['photo'],
            'status' => ($request->get('status') == "on") ? 'yes' : 'no',
            'is_rtl' => ($request->get('is_rtl') == "on") ? 'yes' : 'no',
        ]);
        
        return redirect('languages')->with('message','Language successfully created');

    }

    public function edit($id)
    {
        $languages = Language::where('id', "=", $id)->first();

        return view("languages.edit")->with("languages", $languages);
    }

    public function update(Request $request, $id)
    {

        if ($id > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
        }else{
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'photo' =>$image_validation,
            'code' => 'required|unique:languages,code,'.$id,
        ]);

        if ($validator->fails()) {
            return redirect('languages/edit/'.$id)->withErrors($validator)->withInput();
        }
        $language = Language::find($id);
        
        if ($language) {
            
            $language->name = $request->input('name');
            $language->code = $request->input('code');
            $language->status = $request->has('status') ? 'yes' : 'no';
            $language->is_rtl = $request->has('is_rtl') ? 'yes' : 'no';
            
            if ($request->hasfile('photo')) {
                $destination = public_path('images/languages/'.$language->photo);
                if(File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo');
                $extenstion = $file->getClientOriginalExtension();
                //$filename = time() . '.' . $extenstion;
                $filename = $file->getClientOriginalName();
                $file->move(public_path('images/languages/'), $filename);
               
                $language->photo = $filename;
            }

            $language->save();
        }

        return redirect('languages')->with('message','Language successfully updated');
    }

    public function status(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $languages = Language::find($id);
        $languages->status = ($ischeck == "true")?'yes':'no';
        $languages->save();

    }

    public function delete($id)
    {
       
        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {
               
                for ($i = 0; $i < count($id); $i++) {
                   
                    $languages = Language::find($id[$i]);
                    $languages->delete();
                }

            } else {
                $languages = Language::find($id);
                $languages->delete();
            }

        }

        return redirect('languages')->with('message','Language successfully deleted');
    }

    public function getLangauage()
    {
        $languages = Language::where('status','yes')->get();
     
         return response()->json($languages);
    }

    public function change(Request $request)
    {
        
        App::setLocale($request->lang);
        
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }

    public function getCode($slugid){

        $languages = Language::where('code',$slugid)->get();
        
        return response()->json($languages);
    }

}