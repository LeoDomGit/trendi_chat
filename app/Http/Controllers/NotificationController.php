<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use App\Models\GuestUser;
use App\Models\Notification;
use Validator;
use DB;
use Config;
class NotificationController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index(Request $request)
    {

        $query = Notification::select('*');;
        
        $notifications=  $query->orderBy('created_at','desc')->paginate(10);
        
        return view("notifications.index")->with("notifications",$notifications);

    }
    public function create()
    {
        return view("notifications.send");

    }
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails()){
            return redirect('notification/create')->withErrors($validator)->withInput();
        }

        $msg = 'No users found';

        $title = $request->input('title');
        $message = $request->input('message');
        $send_to = $request->input('send_to');

        $messages = array("body" => $message, "title" => $title, "sound" => "default", "tag" => "notification");

        //Send notification to registered users
        if(in_array('login',$send_to)){

            $users = AppUser::where('fcmtoken', '!=', '')->get();    
            
            $tokens = $insert_data = array();
            
            if(count($users) > 0){
                foreach($users as $user){
                    $tokens[] = $user->fcmtoken;
                    $insert_data[] =  array('title'=> $title,'body' => $message, 'user_id'=> $user->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
                }
                $tokens = implode(',',$tokens);

                GcmController::send_notification($tokens, $messages);
                Notification::insert($insert_data);
                $msg = 'Notification successfully sent';
            }
        }
        
        //Send notification to guest users
        if(in_array('without_login',$send_to)){

            $guests = GuestUser::where('device_id', '!=', '')->get();

            if(count($guests) > 0){
            
                $tokens = '/topics/QuicklAI';
                $insert_data = array();
                foreach($guests as $guest){
                    $insert_data[] =  array('title'=> $title,'body' => $message, 'guest_id'=> $guest->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
                }
                
                GcmController::send_notification($tokens, $messages);
                Notification::insert($insert_data);
                $msg = 'Notification successfully sent';
            }
        }        
           
        return redirect("notification")->with('message',$msg);

    }

    public function delete($id)
    {

        if ($id != "") {
            $notification = Notification::find($id);
            $notification->delete();
        }

        return redirect('notification')->with('message','notification successfully deleted');;
    }
    
}
