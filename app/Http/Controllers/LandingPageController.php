<?php

namespace App\Http\Controllers;
use App\Models\LandingPage;
use Illuminate\Http\Request;


class LandingPageController extends Controller
{

    public function __construct()
    {
	    $this->middleware('auth');
    }
    
    public function index(){
    
    	$template = LandingPage::first();
        
        return view('landingpage.index',compact('template'))->render();
	}
      
    public function save(Request $request)
    {
    	$html_template = $request->get('html_template');
     	
		$template = LandingPage::first();
		if($template){
            $template->html_template = $html_template;
			$template->save();	
		}else{
            LandingPage::create(array('html_template'=>$html_template));
		}
		
    	return redirect('landingpage')->with('message','Page content successfully updated');
    }
}