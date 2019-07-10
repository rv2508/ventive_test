<?php

namespace App\Http\Controllers\Admin\search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Car;

class SearchController extends Controller
{
	 

    public function carSearch()
    {
        $results = Car::orderBy('id', 'DESC')->get();

    	return view('admin.search.search',compact('results'));
    }


    public function resultSearch(Request $request)
    {
    	/*$request = 'bbbb';*/
		$search = Car::where('brand', 'LIKE', "%$request->keyword%")->orwhere('model', 'LIKE', "%$request->keyword%")->get();

		//dd($search);

		$search_result = view('admin.search.result',compact('search'))->render();

		return Response::json(['data' => $search_result]);


    }
}
