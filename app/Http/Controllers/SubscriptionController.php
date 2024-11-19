<?php

namespace App\Http\Controllers;


use App\Models\Subscription;
use Illuminate\Http\Request;
use Validator;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Subscription::select('*');
       
        if($request->get('search') != null){
            $query->where('name','like','%'.$request->get('search').'%');
            $query->orWhere('description','like','%'.$request->get('search').'%');
            $query->orWhere('price','like','%'.$request->get('search').'%');
            $query->orWhere('discount','like','%'.$request->get('search').'%');
        }
        
        $subscriptions=  $query->paginate(10);
                   
        return view("subscriptions.index",compact('subscriptions'));
    }

    public function create()
    {
        return view("subscriptions.create");

    }

   public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'android_subscription_key' => 'required',
            'ios_subscription_key' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        if ($validator->fails()) {
            return redirect('subscriptions/create')->withErrors($validator)->withInput();
        }
        
        Subscription::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'android_subscription_key' => $request->get('android_subscription_key'),
            'ios_subscription_key' => $request->get('ios_subscription_key'),
            'price' => $request->get('price'),
            'discount' => $request->get('discount'),
            'status' => ($request->get('status') == "on") ? 'yes' : 'no',
        ]);
        
        return redirect('subscriptions')->with('message','Subscription successfully created');
    }

    public function edit($id)
    {
        $subscription = Subscription::find($id);
        
        return view("subscriptions.edit",compact('subscription'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'android_subscription_key' => 'required',
            'ios_subscription_key' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('subscriptions/create')->withErrors($validator)->withInput();
        }
        $subscription = Subscription::find($id);
        if ($subscription) {
            $subscription->name = $request->get('name');
            $subscription->description = $request->get('description');
            $subscription->android_subscription_key = $request->get('android_subscription_key');
            $subscription->ios_subscription_key = $request->get('ios_subscription_key');
            $subscription->price = $request->get('price');
            $subscription->discount = $request->get('discount');
            $subscription->status = ($request->get('status') == "on") ? 'yes' : 'no';
            $subscription->save();
        }

        return redirect('subscriptions')->with('message','Subscription successfully updated');
    }

    public function status(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $subscription = Subscription::find($id);
        $subscription->status = ($ischeck == "true")?'yes':'no';
        $subscription->save();
    }

    public function delete($id)
    {
        if ($id != ""){
            $id = json_decode($id);
            if (is_array($id)) {
                for($i = 0; $i < count($id); $i++) {
                    $suggestion = Subscription::find($id[$i]);
                    $suggestion->delete();
                }
            } else {
                $suggestion = Subscription::find($id);
                 $suggestion->delete();
            }
        }
        return redirect('subscriptions')->with('messsage','Subscription successfully deleted');
    }
}
