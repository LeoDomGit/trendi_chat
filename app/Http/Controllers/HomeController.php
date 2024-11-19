<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\GuestUser;
use App\Models\SubscriptionUser;
use App\Models\Category;
use App\Models\Suggestion;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_users = AppUser::count();
        $today_users = AppUser::whereDate('created_at',Carbon::today())->count();
        $total_subscription = SubscriptionUser::count();
        $today_subscription = SubscriptionUser::whereDate('created_at',Carbon::today())->count();
        $total_categories = Category::count();
        $total_suggestions = Suggestion::count();
        $recent_users = AppUser::orderBy('id','desc')->take(10)->get();
        $total_guest_users = GuestUser::count();
        $today_guest_users = GuestUser::whereDate('created_at',Carbon::today())->count();
        
        return view('home')
        ->with("total_users",$total_users)
        ->with("today_users",$today_users)
        ->with("total_subscription",$total_subscription)
        ->with("today_subscription",$today_subscription)
        ->with("total_categories",$total_categories)
        ->with("total_suggestions",$total_suggestions)
        ->with("recent_users",$recent_users)
        ->with("total_guest_users",$total_guest_users)
        ->with("today_guest_users",$today_guest_users);
    }
  
}
