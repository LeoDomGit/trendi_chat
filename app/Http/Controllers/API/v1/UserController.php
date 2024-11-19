<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\GuestUser;
use App\Models\Setting;
use App\Models\UserAccessToken;
use App\Models\SubscriptionUser;
use App\Models\VerifyEmail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\ForgotPassword;

class UserController extends Controller
{

    public function CheckEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $email = $request->get('email');

        if(VerifyEmail::where('email',$email)->exists()){
            $record =  VerifyEmail::where('email',$email)->first();
            $record->delete();
        }

        $otp = mt_rand(100000,999999);

        VerifyEmail::create(['email'=>$email,'otp'=>$otp]);
        
        Mail::to($email)->send(new EmailVerification($otp));

        $response['success'] = 'Success';
        $response['error'] =  NULL;
        $response['message'] = 'Verification mail sent to you on your email address';    

        return response()->json($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();    
        
        $email = $request->get('email');
        $password = $request->get('password');
        $password = md5($password);
        $fcm_token = $request->get('fcmtoken');
        
        $user = AppUser::where('email', $email)->first();

        if($user){

            if($user->password == $password){

                unset($user->password);
                $user->accesstoken = UserAccessToken::where('user_id', $user->id)->value('accesstoken');
                $appuser = AppUser::find($user->id);
                if ($appuser) {
                    $appuser->fcmtoken = $fcm_token;
                }
                $user->fcmtoken =$appuser->fcmtoken;
                $appuser->save();

                if($user->photo && file_exists(public_path('images/users/'.$user->photo))){
                    $user->photo = asset('images/users/'.$user->photo);
                }else{
                    $user->photo = asset('images/default_user.png');
                }

                $response['success'] = 'Success';
                $response['error'] =   NULL;
                $response['message'] = 'Login successfull';
                $response['data'] = $user;
            }else{
                $response['success'] = 'Failed';
                $response['error'] = 'Incorrect password';
            }

        } else {

            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }

        return response()->json($response);
    }

    public function chatStatistics(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:app,guest',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
            'chat_word_count' =>'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 

        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        $chat_word_count = $request->get('chat_word_count');
        $setting = Setting::find(1);
        $data = array();
        if($user_type == "app"){

            $user = AppUser::find($user_id);
            
            $user->chat_request = (int)$user->chat_request + 1;
            $user->chat_word_count = (int)$user->chat_word_count + $chat_word_count;
            $data['chat_request']=$user->chat_request;
            $data['chat_word_count'] =  $user->chat_word_count;
            $user->save();
           

        }else if($user_type == "guest"){

            $user = GuestUser::where('device_id',$device_id)->first();
            
            $user->chat_request = (int)$user->chat_request + 1;
            $user->chat_word_count = (int)$user->chat_word_count + $chat_word_count;
            $data['chat_request']=$user->chat_request;
            $data['chat_word_count'] =  $user->chat_word_count;
            $user->save();
        }

        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $data;

        return response()->json($response);
    }

    public function promsStatistics(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:app,guest',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
            'proms_word_count' =>'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 

        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        $proms_word_count = $request->get('proms_word_count');
        $setting = Setting::find(1);
        $data = array();
        if($user_type == "app"){

            $user = AppUser::find($user_id);
            
            $user->proms_request = (int)$user->proms_request + 1;
            $user->proms_word_count = (int)$user->proms_word_count + $proms_word_count;
            $data['proms_request']=$user->proms_request;
            $data['proms_word_count'] =  $user->proms_word_count;
            $user->save();
           

        }else if($user_type == "guest"){

            $user = GuestUser::where('device_id',$device_id)->first();
            
            $user->proms_request = (int)$user->proms_request + 1;
            $user->proms_word_count = (int)$user->proms_word_count + $proms_word_count;
            $data['proms_request']=$user->proms_request;
            $data['proms_word_count'] =  $user->proms_word_count;
            $user->save();
        }

        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $data;

        return response()->json($response);
    }
    public function imageStatistics(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:app,guest',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
           
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 

        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
       // $proms_word_count = $request->get('proms_word_count');
        $setting = Setting::find(1);
        $data = array();
        if($user_type == "app"){

            $user = AppUser::find($user_id);
            
            $user->image_request = (int)$user->image_request + 1;
           // $user->proms_word_count = (int)$user->proms_word_count + $proms_word_count;
            $data['image_request']=$user->image_request;
           // $data['proms_word_count'] =  $user->proms_word_count;
            $user->save();
           

        }else if($user_type == "guest"){

            $user = GuestUser::where('device_id',$device_id)->first();
            
            $user->image_request = (int)$user->image_request + 1;
            //$user->proms_word_count = (int)$user->proms_word_count + $proms_word_count;
            $data['image_request']=$user->image_request;
            //$data['proms_word_count'] =  $user->proms_word_count;
            $user->save();
        }

        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $data;

        return response()->json($response);
    }
    public function getStatistics(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:app,guest',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
           
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 
        $response = array();
        $data = array();
        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        if($user_type == "app"){
            $count = AppUser::where('id',$user_id)->where('status','yes')->first();
            
            $count->chat_request=$count->chat_request;
            $count->chat_word_count=$count->chat_word_count;
            $count->proms_request=$count->proms_request;
            $count->proms_word_count=$count->proms_word_count;
            $count->image_request=$count->image_request;

            $data['chat_request'] = $count->chat_request;
            $data['chat_word_count'] =  $count->chat_word_count;
            $data['proms_request'] = $count->proms_request;
            $data['proms_word_count'] =  $count->proms_word_count;
            $data['image_request']= $count->image_request;
        }
        else if($user_type == "guest"){
            $count = GuestUser::where('device_id',$device_id)->first();
            
            $count->chat_request=$count->chat_request;
            $count->chat_word_count=$count->chat_word_count;
            $count->proms_request=$count->proms_request;
            $count->proms_word_count=$count->proms_word_count;
            $count->image_request=$count->image_request;

            $data['chat_request'] = $count->chat_request;
            $data['chat_word_count'] =  $count->chat_word_count;
            $data['proms_request'] = $count->proms_request;
            $data['proms_word_count'] =  $count->proms_word_count;
            $data['image_request']= $count->image_request;
        }
        $response['success'] = 'Success';
        $response['error'] =    NULL;
        $response['data'] = $data;
        
        return response()->json($response);
       

    }
    public function guest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $device_id = $request->get('device_id');
        $fcm_token = $request->get('fcmtoken');
        if(GuestUser::where('device_id',$device_id)->exists()){
            $device = GuestUser::where('device_id',$device_id)->first();
            if ($device) {
                $device->fcmtoken = $fcm_token;
            }
            $device->save();
        }else{
            $setting = Setting::find(1);
            $device = GuestUser::create([
                'device_id'=> $device_id,
                'writer_limit' => $setting->writer_limit,
                'chat_limit' => $setting->chat_limit,
                'image_limit' => $setting->image_limit,
            ]);
        }

        $response = array();    
        $response['success'] = 'Success';
        $response['error'] =   NULL;
        $response['message'] = 'Login successfull';
        $response['data'] = $device;

        return response()->json($response);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'otp' => 'required',
        ]);
        
        $referral_code=strtoupper(bin2hex(openssl_random_pseudo_bytes(4)));

        if ($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();        
        
        $email = $request->get('email');
        $join_by_referral_code = $request->get('join_by_referral_code') != '' ? $request->get('join_by_referral_code') : null;
        $otp = $request->get('otp');
        $fcm_token = $request->get('fcmtoken');

        $check_referral_code=AppUser::where('referral_code', $join_by_referral_code)->first();
        if(($check_referral_code->referral_code ?? '') != $join_by_referral_code){
           
            $response['success'] = 'Failed';
            $response['error'] = 'Referral Code not Exits';
            return response()->json($response);
            
        }

        if(VerifyEmail::where('email',$email)->exists()){
            $record =  VerifyEmail::where('email',$email)->first();
            if($record->otp === $otp){
                $record->delete();
            }else{
                $response['success'] = 'Failed';
                $response['error'] = 'Invalid OTP';
                return response()->json($response);
            }
        }else{
            $response['success'] = 'Failed';
            $response['error'] = 'Required email verification';
            return response()->json($response);
        }

        $name = $request->get('name');
        $password = $request->get('password');
        $password = md5($password);
        $customer_id = uniqid();
        
        if(AppUser::where('email', $email)->exists()) {
            
            $response['success'] = 'Failed';
            $response['error'] = 'Email address already exist';

        } else {
            
            $setting = Setting::find(1);

            $user_id = AppUser::create([
                'name' => $name, 
                'customer_id' => $customer_id, 
                'password' => $password, 
                'email' => $email,
                'status' => 'yes',
                'referral_code' => $referral_code,
                'join_by_referral_code' =>$join_by_referral_code,
                'writer_limit' => $setting->writer_limit,
                'chat_limit' => $setting->chat_limit,
                'image_limit' => $setting->image_limit,
               // 'reffered_limit' => $setting->reffered_limit,
                'fcmtoken' => $fcm_token,
            ])->id;
           
            $old_referral_code=AppUser::where('referral_code', $join_by_referral_code)->first();
           
                if($old_referral_code->referral_code ?? ''){
                
                 $old_referral_code->writer_limit= ($old_referral_code->writer_limit) + ($setting->reffered_limit);//  ($old_referral_code->reffered_limit) + 5;
                 $old_referral_code->chat_limit=($old_referral_code->chat_limit) + ($setting->reffered_limit);
                 $old_referral_code->image_limit = ($old_referral_code->image_limit) + ($setting->reffered_limit);
                 $old_referral_code->save();
                 
                }

            $user = AppUser::find($user_id);

            unset($user['password']);
            $user->accesstoken = $this->createUserAccessToken($user->id);
            $user->photo = asset('images/default_user.png');
            
            $response['success'] = 'Success';
            $response['error'] =    NULL;
            $response['message'] = 'User successfully registered';
            $response['data'] = $user;
        }

        return response()->json($response);
    }

    public function UpdateProfile(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();
        $user_id = $request->get('user_id');
        $name = $request->get('name');
        $email = $request->get('email');
        
        $user = AppUser::find($user_id);
        
        if($user){

            if($name){
                $user->name = $name;
            }
            if($email){
                $user->email = $email;
            }    
            
            $user->save();
            
            $response['success'] = 'Success';
            $response['error'] =   NULL;
            $response['message'] = 'Profile successfully updated';
            
        }else{
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }

        return response()->json($response);
    }

    public function UpdateProfilePicture(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'photo' => "required|mimes:jpeg,png,jpg",
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }
        
        $response = array();

        $user_id = $request->get('user_id');
        $user = AppUser::find($user_id);

        if($user){

            $destination = public_path('images/users/'.$user->photo);
            if(File::exists($destination)) {
                File::delete($destination);
            }
            
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = $time;
            $file->move(public_path('images/users'),$filename);
            
            $user->photo = $filename;
            $user->save();
            
            $data = array();
            if($user->photo && file_exists(public_path('images/users/'.$user->photo))){
                $data['photo'] = asset('images/users/'.$user->photo);
            }else{
                $data['photo'] = asset('images/default_user.png');
            }

            $response['success'] = 'Success';
            $response['error'] =   NULL;
            $response['message'] = 'Profile picture successfully updated';
            $response['data'] = $data;
            
        }else{

            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }

        return response()->json($response);
    }

    public function UpdatePassword(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();
        $user_id = $request->get('user_id');
        $password = $request->get('password');
        
        $user = AppUser::find($user_id);
        
        if($user){

            $user->password = md5($password); 
            $user->save();
            
            $response['success'] = 'Success';
            $response['error'] =   NULL;
            $response['message'] = 'Password successfully updated';
            
        }else{
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }

        return response()->json($response);
    }

    public function GetUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();
        

        $user_id = $request->get('user_id');
        $user = AppUser::find($user_id);
        $setting = Setting::find(1);
        $user['reffered_limit']=$setting->reffered_limit;
        
        if ($user) {
            unset($user->password);
            if($user->photo && file_exists(public_path('images/users/'.$user->photo))){
                $user->photo = asset('images/users/'.$user->photo);
            }else{
                $user->photo = asset('images/default_user.png');
            }
            $response['success'] = 'Success';
            $response['error'] =  NULL;
            $response['data'] = $user;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }
    public function wordCount(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'word_count' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }
        $user_id = $request->get('user_id');
        $word_count = $request->get('word_count');
        
        $response = array();
        $data = array();
        $data['user_id'] = $user_id;
        $data['word_count'] = $word_count;
        
        $response['success'] = 'Success';
        $response['error'] =   NULL;
        $response['data'] = $data;
        return response()->json($response);

    }
    public function ResetLimit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'type' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        $type = $request->get('type');
        
        $user = AppUser::find($user_id);
        if ($user) {
            
            if($type == "writer"){
                $user->writer_limit =  ($user->writer_limit == 0)?0:$user->writer_limit - 1;   
            }
            if($type == "chat"){
                $user->chat_limit =  ($user->chat_limit == 0)?0:$user->chat_limit - 1;   
            }
            if($type == "image"){
                $user->image_limit =  ($user->image_limit == 0)?0:$user->image_limit - 1;   
            }
            $user->save();

            $data = array();
            $data['writer_limit'] = strval($user->writer_limit);
            $data['chat_limit'] = strval($user->chat_limit);
            $data['image_limit'] = strval($user->image_limit);

            $response['success'] = 'Success';
            $response['error'] =   NULL;
            $response['data'] = $data;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function GuestResetLimit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'type' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $device_id = $request->get('device_id');
        $type = $request->get('type');
        
        if(GuestUser::where('device_id',$device_id)->exists()){
            
            $device = GuestUser::where('device_id',$device_id)->first();
            
            if($type == "writer"){
                $device->writer_limit =  ($device->writer_limit == 0)?0:$device->writer_limit - 1;   
            }
            if($type == "chat"){
                $device->chat_limit =  ($device->chat_limit == 0)?0:$device->chat_limit - 1;   
            }
            if($type == "image"){
                $device->image_limit =  ($device->image_limit == 0)?0:$device->image_limit - 1;   
            }
            $device->save();

            $data = array();
            $data['writer_limit'] = strval($device->writer_limit);
            $data['chat_limit'] = strval($device->chat_limit);
            $data['image_limit'] = strval($device->image_limit);

            $response['success'] = 'Success';
            $response['error'] =   NULL;
            $response['data'] = $data;
        }else{
            $response['success'] = 'Failed';
            $response['error'] = 'Device not found';    
        }
        
        return response()->json($response);
    }

    public function createUserAccessToken($user_id)
    {
        $token = $this->getUniqAccessToken();
        $user = UserAccessToken::where('user_id', $user_id)->first();
        if ($user) {
            UserAccessToken::where('id', $user->id)->update(['accesstoken' => $token]);
        } else {
            UserAccessToken::create(['user_id' => $user_id, 'accesstoken' => $token]);
        }
        return $token;
    }

    public function getUniqAccessToken()
    {
        $accessget = 0;
        $accessToken = '';
        while ($accessget == 0) {
            $accessToken = md5(uniqid(mt_rand(), true));
            $user = UserAccessToken::where('accesstoken', $accessToken)->first();
            if (!$user) {
                $accessget = 1;
            }
        }
        return $accessToken;
    }

    public function DeleteAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        
        $user = AppUser::find($user_id);
        
        if ($user) {

            $user->delete();

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
            
            $response['success'] = 'Success';
            $response['error'] =  NULL;
            $response['message'] = 'Account successfully deleted';
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function ForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $email = $request->get('email');
        
        $user = AppUser::where('email',$email)->first();
        
        if ($user) {

            $name = $user->name;
            $password = mt_rand();
            
            $user->password = md5($password);
            $user->save();

            Mail::to($email)->send(new ForgotPassword($email,$name,$password));

            $response['success'] = 'Success';
            $response['error'] =  NULL;
            $response['message'] = 'Your password has been sent to your email address';    
        }else{
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }

        return response()->json($response);
    }

    public function SavePromsHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        
        $user = AppUser::find($user_id);
        
        if ($user) {
            
            $filename = '/proms/'.$user_id.'/data.txt';
            if(Storage::exists($filename)){
                $stored_data = Storage::get($filename);
                $save_data = json_decode($stored_data,true);
                $save_data[] = array(
                    'category_id' => $request->get('category_id'),
                    'category_name' => $request->get('category_name'),
                    'subject' => $request->get('subject'),
                    'answer' => $request->get('answer'),
                );
            }else{
                $save_data = array();
                $save_data[] = array(
                    'category_id' => $request->get('category_id'),
                    'category_name' => $request->get('category_name'),
                    'subject' => $request->get('subject'),
                    'answer' => $request->get('answer'),
                );
            }
            
            Storage::disk('local')->put($filename,json_encode($save_data));

            $response['success'] = 'Success';
            $response['error'] =  NULL;
            $response['message'] = 'Proms history successfully saved';
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function GetPromsHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        $user = AppUser::find($user_id);
        
        if($user){
            
            $filename = '/proms/'.$user_id.'/data.txt';
            
            if(Storage::exists($filename)){

                $stored_data = Storage::get($filename);
                $stored_data = json_decode($stored_data,true);

                $category_id = $request->get('category_id');
                if($category_id > 0){
                    $stored_data = array_filter($stored_data, function ($item) use ($category_id) {
                        if (stripos($item['category_id'],$category_id) !== false) {
                            return true;
                        }
                        return false;
                    });
                    $stored_data = array_values($stored_data);
                }

                foreach($stored_data as $key=>$data){
                    if($data['category_id'] > 0){
                        $filename = Category::where('id',$data['category_id'])->value('photo');
                        $stored_data[$key]['category_photo'] = asset('images/category/'.$filename);
                    }
                }
                
                //Reset search history to get last is first
                $stored_data = array_reverse($stored_data);
                
                $response['success'] = 'Success';
                $response['error'] =  NULL;
                $response['data'] = $stored_data;
                
            }else{
                $response['success'] = 'Failed';
                $response['error'] = 'History not found';
            }

        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function SaveChatHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        
        $user = AppUser::find($user_id);
        
        if ($user) {
            
            $filename = '/chats/'.$user_id.'/data.txt';
            if(Storage::exists($filename)){
                $stored_data = Storage::get($filename);
                $save_data = json_decode($stored_data,true);
                $save_data[] = array(
                    'chat' => $request->get('chat'),
                    'msg' => $request->get('msg'),
                );
            }else{
                $save_data = array();
                $save_data[] = array(
                    'chat' => $request->get('chat'),
                    'msg' => $request->get('msg'),
                );
            }
            
            Storage::disk('local')->put($filename,json_encode($save_data));

            $response['success'] = 'Success';
            $response['error'] =  NULL;
            $response['message'] = 'Chat history successfully saved';
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function GetChatHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        $user = AppUser::find($user_id);

        if($user){
            
            $filename = '/chats/'.$user_id.'/data.txt';
            
            if(Storage::exists($filename)){

                $stored_data = Storage::get($filename);
                $stored_data = json_decode($stored_data,true);

                $response['success'] = 'Success';
                $response['error'] =  NULL;
                $response['data'] = $stored_data;
                
            }else{
                $response['success'] = 'Failed';
                $response['error'] = 'History not found';
            }

        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function SocialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'photo' => "required",
            'fcmtoken' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();    
        
        $name = $request->get('name');
        $email = $request->get('email');
        $photo = $request->get('photo');
        $fcm_token = $request->get('fcmtoken');
        
        $user = AppUser::where('email', $email)->first();

        if($user){

            $user->fcmtoken = $fcm_token;
            $user->save();

            $user->accesstoken = $this->createUserAccessToken($user->id);
            unset($user->password);    
            $user->photo = $photo;

            $response['success'] = 'Success';
            $response['error'] =   NULL;
            $response['message'] = 'Login successfull';
            $response['data'] = $user;

        } else {

            $setting = Setting::find(1);

            $customer_id = uniqid();
            $password = md5('12345678');
            $user_id = AppUser::create([
                'name' => $name, 
                'customer_id' => $customer_id, 
                'password' => $password, 
                'email' => $email,
                'status' => 'yes',
                'writer_limit' => $setting->writer_limit,
                'chat_limit' => $setting->chat_limit,
                'image_limit' => $setting->image_limit,
                'fcmtoken' => $fcm_token,
            ])->id;

            $user = AppUser::find($user_id);

            $user->fcmtoken = $fcm_token;
            $user->save();

            $user->accesstoken = $this->createUserAccessToken($user->id);
            unset($user->password);    
            $user->photo = $photo;
            
            $response['success'] = 'Success';
            $response['error'] =    NULL;
            $response['message'] = 'Login successfull';
            $response['data'] = $user;
        }

        return response()->json($response);
    }

    public function DeletePromsHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'subject' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        $user = AppUser::find($user_id);
        
        if($user){
            
            $filename = '/proms/'.$user_id.'/data.txt';
            
            if(Storage::exists($filename)){

                $stored_data = Storage::get($filename);
                $stored_data = json_decode($stored_data,true);

                $subject = $request->get('subject');

                foreach($stored_data as $key=>$data){
                    if($data['subject'] == $subject){
                        unset($stored_data[$key]);
                    }
                }
                $stored_data = array_values($stored_data);
                
                Storage::disk('local')->put($filename,json_encode($stored_data));
                
                //Reset search history to get last is first
                $stored_data = array_reverse($stored_data);
                
                $response['success'] = 'Success';
                $response['error'] =  NULL;
                $response['data'] = $stored_data;
                
            }else{
                $response['success'] = 'Failed';
                $response['error'] = 'History not found';
            }

        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

    public function DeleteChatHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        }

        $response = array();

        $user_id = $request->get('user_id');
        $user = AppUser::find($user_id);
        
        if($user){
            
            $filename = '/chats/'.$user_id.'/data.txt';
            
            if(Storage::exists($filename)){

                Storage::deleteDirectory('/chats/'.$user_id);    
                
                $response['success'] = 'Success';
                $response['error'] =  NULL;
                
            }else{
                $response['success'] = 'Failed';
                $response['error'] = 'History not found';
            }

        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'User account does not exist';
        }
        
        return response()->json($response);
    }

}
