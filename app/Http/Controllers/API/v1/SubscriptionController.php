<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Validator;

class SubscriptionController extends Controller
{

    public function index()
    {
        $subscriptions = Subscription::where('status','yes')->get();

        $response = array();
        $response['success'] = 'Success';
        $response['error'] =    NULL;
        $response['data'] = $subscriptions;
        
        return response()->json($response);
    }

    public function GetUserSubscription(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 
        
        $user_id = $request->get('user_id');

        $user_subscription = AppUser::with('subscription')->find($user_id);

        $response = array();
        $response['success'] = 'Success';
        $response['error'] =    NULL;
        $response['data'] = isset($user_subscription->subscription) ? $user_subscription->subscription : [];
        
        return response()->json($response);
    }

    public function CreateUserSubscription(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'subscription_id' => 'required',
            'transaction_details' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 
        
        $user_id = $request->get('user_id');

        if(SubscriptionUser::where('user_id',$user_id)->exists()){
            $subscription = SubscriptionUser::where('user_id',$user_id)->first();
            $subscription->subscription_id = $request->get('subscription_id');
            $subscription->transaction_details = $request->get('transaction_details');
            $subscription->save();
        }else{
            $subscription = SubscriptionUser::create([
                'user_id' => $user_id,
                'subscription_id' => $request->get('subscription_id'),
                'transaction_details' => $request->get('transaction_details'),
            ]);
        }    
        
        $response = array();
        $response['success'] = 'Success';
        $response['message'] = 'Subscription successfully created';
        $response['data'] = $subscription;
        
        return response()->json($response);
    }
}
