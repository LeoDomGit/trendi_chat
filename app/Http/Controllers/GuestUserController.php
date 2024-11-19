<?php

namespace App\Http\Controllers;

use App\Models\GuestUser;
use Illuminate\Http\Request;

class GuestUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = GuestUser::select('*');

        if($request->get('search') != null){
            $query->where('device_id','like','%'.$request->get('search').'%');
            $query->orWhere('writer_limit','like','%'.$request->get('search').'%');
            $query->orWhere('chat_limit','like','%'.$request->get('search').'%');
            $query->orWhere('image_limit','like','%'.$request->get('search').'%');
        }

        $limit = $request->limit ? : 50;

        $guestusers = $query->orderBy('id','desc')->paginate($limit);

        return view("guestusers.index",compact('guestusers'));
    }
    
    public function delete($id)
    {

        if ($id != "") {
            $id = json_decode($id);
            if (is_array($id)) {
                for ($i = 0; $i < count($id); $i++) {
                    $GuestUser = GuestUser::find($id[$i]);
                    $GuestUser->delete();
                }
            } else {
                $GuestUser = GuestUser::find($id);
                $GuestUser->delete();
            }
        }

        return redirect('guestusers')->with('message','User successfully deleted');
    }
}