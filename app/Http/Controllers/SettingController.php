<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\AppUser;
use App\Models\GuestUser;
use Illuminate\Http\Request;
use Validator;

class SettingController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index()
    {

        $settings = Setting::first();
        
        return view("settings.index")->with("settings",$settings);

    }

    public function limit()
    {

        $settings = Setting::first();
        
        return view("settings.limit")->with("settings",$settings);

    }

    public function generalUpdate(Request $request, $id)
    {

		$validator = Validator::make($request->all(),[
            'apikey_android_revenuecat' => 'required',
            'apikey_ios_revenuecat' => 'required',
            'openai_api_key' => 'required',
            'support_email' => 'required',
        ]);

        if($validator->fails()){
            return redirect('settings/general')->withErrors($validator)->withInput();
        }

    	$settings = Setting::find($id);
        $settings->apikey_android_revenuecat = $request->input('apikey_android_revenuecat');
        $settings->apikey_ios_revenuecat = $request->input('apikey_ios_revenuecat');
        $settings->openai_api_key = $request->input('openai_api_key');
        $settings->add_is_enabled = ($request->input('add_is_enabled') == "on")?'yes':'no';
        $settings->android_app_id = $request->input('android_app_id');
        $settings->ios_app_id = $request->input('ios_app_id');
        $settings->android_banner_id = $request->input('android_banner_id');
        $settings->ios_banner_id = $request->input('ios_banner_id');
        $settings->android_interstitial_id = $request->input('android_interstitial_id');
        $settings->ios_interstitial_id = $request->input('ios_interstitial_id');
        $settings->support_email = $request->input('support_email');
        $settings->privacy_policy = $request->input('privacy_policy');
        $settings->terms_and_conditions = $request->input('terms_and_conditions');
        $settings->faq = $request->input('faq');
        $settings->app_version = $request->input('app_version');
        $settings->ads_writer_limit = $request->input('ads_writer_limit');
        $settings->ads_chat_limit = $request->input('ads_chat_limit');
        $settings->ads_image_limit = $request->input('ads_image_limit');
        
        $settings->android_reward_ads_id = $request->input('android_reward_ads_id');
        $settings->ios_reward_ads_id = $request->input('ios_reward_ads_id');
        $settings->app_homepage_theme = $request->input('app_homepage_theme');
        $settings->model_type = $request->input('model_type');
        $settings->save();

		return redirect('settings/general')->with('message','Setting successfully updated');
    }

    public function limitUpdate(Request $request, $id)
    {

		$validator = Validator::make($request->all(),[
            'writer_limit' => 'required',
            'chat_limit' => 'required',
            'image_limit' => 'required',
            'reffered_limit' => 'required',
        ]);

        if($validator->fails()){
            return redirect('settings')->withErrors($validator)->withInput();
        }

    	$settings = Setting::find($id);

        $settings->writer_limit = $request->input('writer_limit');

        $settings->chat_limit = $request->input('chat_limit');

        $settings->image_limit = $request->input('image_limit');

        $settings->reffered_limit = $request->input('reffered_limit');

        $settings->save();

        //Reset access limit for app loggedin users
        $app_users = AppUser::all();
        if(count($app_users) > 0){
            foreach($app_users as $app_user){
                $app_user->writer_limit = $request->input('writer_limit');
                $app_user->chat_limit = $request->input('chat_limit');
                $app_user->image_limit = $request->input('image_limit');
                $app_user->save();
            }
        }

        //Reset access limit for app guest users
        $guest_users = GuestUser::all();
        if(count($guest_users) > 0){
            foreach($guest_users as $guest_user){
                $guest_user->writer_limit = $request->input('writer_limit');
                $guest_user->chat_limit = $request->input('chat_limit');
                $guest_user->image_limit = $request->input('image_limit');
                $guest_user->save();
            }
        }
        
		return redirect('settings/limit')->with('message','Setting successfully updated');
    }
      
}
