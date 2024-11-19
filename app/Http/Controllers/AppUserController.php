<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Subscription;
use App\Models\UserAccessToken;
use App\Models\SubscriptionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Hash;

class AppUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = AppUser::select('*');
        
        if($request->search != null){
            $query->orWhere('name','like','%'.$request->search.'%');
            $query->orWhere('email','like','%'.$request->search.'%');
        }
        
        $limit = $request->limit ? : 50;

        $appusers = $query->orderBy('id','desc')->paginate($limit);

        $appusers->map(function($appuser){
            if($appuser->subscription){
                $subscription_name = Subscription::find($appuser->subscription->subscription_id)->value('name');
                $appuser->subscription_name = $subscription_name;
            }
            return $appuser;
        });
       
        return view("appusers.index",compact('appusers'));
    }

    public function edit($id)
    {
        $appuser = AppUser::find($id);
        
        if($appuser->subscription){
            $subscription_name = Subscription::find($appuser->subscription->subscription_id)->value('name');
            $appuser->subscription_name = $subscription_name;
        }
        
        return view("appusers.edit",compact('appuser'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:app_users,email,'.$id,
            'photo' => 'mimes:jpeg,jpg,png',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $password = $request->input('password');    
        if($password != ''){
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $appuser = AppUser::find($id);
        
        if ($appuser) {

            $appuser->name = $request->get('name');
            $appuser->phone = $request->get('phone');
            $appuser->email = $request->get('email');

            if ($request->hasfile('photo')) {
                $destination = public_path('images/banners/'. $appuser->photo);
                if(File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move(public_path('images/users/'), $filename);
                $appuser->photo = $filename;
            }

            if ($password != '') {
                $appuser->password = md5($password);
            }

            $appuser->writer_limit = $request->get('writer_limit');
            $appuser->chat_limit = $request->get('chat_limit');
            $appuser->image_limit = $request->get('image_limit');
            $appuser->status = ($request->get('status') == 'on') ? 'yes' : 'no';
            $appuser->save();
        }

        return redirect('appusers')->with('message','User detail successfully updated');
    }

    public function status(Request $request)
    {
        $ischeck = $request->ischeck;
        $id = $request->id;
        $appuser = AppUser::find($id);
        $appuser->status = ($ischeck == "true")?'yes':'no';
        $appuser->save();
    }
    
    public function delete($id)
    {

        if ($id != "") {

            $id = json_decode($id);
            
            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    
                    $user_id = $id[$i];
                    
                    $appuser = AppUser::find($user_id);
                    $appuser->delete();

                    //Remove user accesstoken    
                    $user_accesstoken = UserAccessToken::where('user_id',$user_id)->first();
                    if($user_accesstoken){
                        $user_accesstoken->delete();
                    }

                    //Remove user subscription    
                    $user_subscription = SubscriptionUser::where('user_id',$user_id)->first();
                    if($user_subscription){
                        $user_subscription->delete();
                    }
                    
                    //Remove user search history
                    Storage::deleteDirectory('/proms/'.$user_id);        
                    
                    //Remove user chat history
                    Storage::deleteDirectory('/chats/'.$user_id);  

                }

            } else {
                
                $user_id = $id;

                $appuser = AppUser::find($user_id);
                $appuser->delete();

                //Remove user accesstoken    
                $user_accesstoken = UserAccessToken::where('user_id',$user_id)->first();
                if($user_accesstoken){
                    $user_accesstoken->delete();
                }

                //Remove user subscription    
                $user_subscription = SubscriptionUser::where('user_id',$user_id)->first();
                if($user_subscription){
                    $user_subscription->delete();
                }
                
                //Remove user search history
                Storage::deleteDirectory('/proms/'.$user_id);        
                
                //Remove user chat history
                Storage::deleteDirectory('/chats/'.$user_id);  

            }
        }

        return redirect('appusers')->with('message','User successfully deleted');
    }
}