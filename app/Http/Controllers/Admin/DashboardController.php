<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class DashboardController extends Controller
{
	public function __construct()
    {       
       $this->middleware(function ($request, $next) 
       {
	        if (!Auth::user()) 
	        {
	            return redirect('/admin');
	        }
	        else
	        {
	        	return $next($request);
	        }	
           
        });
    }



   public function dashboard()
    {
    	return view('admin.dashboard');
    }
}
