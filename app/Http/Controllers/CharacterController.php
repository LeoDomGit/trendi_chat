<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class CharacterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Character::select('*');
        
        if($request->search != null){
            $query->where('name','like','%'.$request->search.'%');
        }
        
        $characters=  $query->paginate(10);
        
        return view("characters.index")->with('characters',$characters);
    }

    public function create()
    {

        return view("characters.create");
    }

   public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'photo' => 'required|mimes:jpeg,jpg,png,gif',
        ]);

        if ($validator->fails()) {
            return redirect('characters/create')->withErrors($validator)->withInput();
        }

        $data=$request->all();
       
        if ($request->hasfile('photo')) {
            $destination = public_path('images/characters/'. $data['photo']);
            if(File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move(public_path('images/characters/'), $filename);
            $data['photo']=$filename;
            
        }
        Character::create([
            'name' => $request->get('name'),
            'photo' => $data['photo'],
            'lock' => ($request->get('lock') == "on") ? 'yes' : 'no',
        ]);
        
        return redirect('characters')->with('message','Character successfully created');

    }

    public function edit($id)
    {
        $characters = Character::where('id', "=", $id)->first();

        return view("characters.edit")->with("characters", $characters);
    }

    public function update(Request $request, $id)
    {

        if ($id > 0) {
            $image_validation = "mimes:jpeg,jpg,png,gif";
        }else{
            $image_validation = "required|mimes:jpeg,jpg,png,gif";
        }
        
        $validator = Validator::make($request->all(), $rules = [
            'name' => 'required',
            'photo' =>$image_validation,
        ]);

        if ($validator->fails()) {
            return redirect('characters/edit/'.$id)->withErrors($validator)->withInput();
        }

        $name = $request->input('name');
        $lock = $request->has('lock') ? 'yes' : 'no';

        $characters = Character::find($id);
        
        if ($characters) {
            $characters->name = $name;
            $characters->lock = $lock;
            $characters->updated_at = date('Y-m-d H:i:s');
            $characters->name = $request->input('name');

            if ($request->hasfile('photo')) {
                $destination = public_path('images/characters/'.$characters->photo);
                if(File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move(public_path('images/characters/'), $filename);
               
                $characters->photo = $filename;
            }

            $characters->save();
        }

        return redirect('characters')->with('message','Character successfully updated');
    }

    public function lock(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $characters = Character::find($id);
        $characters->lock = ($ischeck == "true")?'yes':'no';
        $characters->save();

    }

    public function delete($id)
    {
       
        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {
               
                for ($i = 0; $i < count($id); $i++) {
                   
                    $characters = Character::find($id[$i]);
                    $characters->delete();
                }

            } else {
                $characters = Character::find($id);
                $characters->delete();
            }

        }

        return redirect('characters')->with('message','Character successfully deleted');
    }

}