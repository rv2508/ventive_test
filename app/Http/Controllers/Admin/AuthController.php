<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Auth;


class AuthController extends Controller
{
    public function checklogin(Request $request)
    {
    	//dd($request->all());

    	$rules = array(
      	'email' => 'required|email',
      	'password' => 'required|alphaNum|min:8');
     

      	$validator = Validator::make(Input::all() , $rules);
     
      	if ($validator->fails())
      	{
        	return Redirect::to('login')->withErrors($validator) 
        	->withInput(Input::except('password')); 
       	}
	    else
	    {
	    
	    	$userdata = array(
	      	'email' => Input::get('email') ,
	      	'password' => Input::get('password')
	    	);

	        
	        if (Auth::attempt($userdata))
	        {

	          
	           return Redirect::to('/admin/dashboard');
	          
	        }
	        else
	        {
	          	// validation not successful, send back to form
	          	return Redirect::to('/admin');
	        }
		}
    }


    

}


    
        