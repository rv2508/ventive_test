<?php

namespace App\Http\Controllers\Admin\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Car;

class CarController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }


	public function car()
    {
    	$results = Car::orderBy('id', 'DESC')->get();

        return view('admin.car.car',compact('results'));
    }


    public function carSave(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $car = $request->all(); 
		unset($car['_token']);
        $car['created_at']=date('Y-m-d H:i:s');
        $car['updated_at']=date('Y-m-d H:i:s');
       	$image = $request->file('image');
       	if(!empty($image))
        {
	       	$path = public_path(). '/img_upload/car_images/';
	       	$filename = time() . '.' . $image->getClientOriginalExtension();
	       	$image->move($path, $filename);
	        unset($car['image']);
	       	$car['image'] = $filename;
	    }   	
		
			Car::insert($car);
		 	$results = Car::orderBy('id', 'DESC')->get();
			$car_data = view('admin.car.car_data',compact('results'))->render();
			return response()->json(['status' => 1,'car_data' => $car_data]);
    }

    public function carUpdate(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $car = $request->all(); 
		unset($car['_token']);
        $car['updated_at']=date('Y-m-d H:i:s');
       	$image = $request->file('image');
       	if(!empty($image))
        {
	       	$path = public_path(). '/img_upload/car_images/';
	       	$filename = time() . '.' . $image->getClientOriginalExtension();
	       	$image->move($path, $filename);
	        unset($car['image']);
	       	$car['image'] = $filename;
	    }   
			Car::where('id',$car['id'])->update($car);	
			
		 	$results = Car::orderBy('id', 'DESC')->get();
			$car_data = view('admin.car.car_data',compact('results'))->render();
			return response()->json(['status' => 1,'car_data' => $car_data]);
    }
    public function carDelete(Request $request)
    {	
    	Car::where('id',$request->id)->delete();	
    	$results = Car::orderBy('id', 'DESC')->get();
		$car_data = view('admin.car.car_data',compact('results'))->render();
		return response()->json(['status' => 1,'car_data' => $car_data]);
    }   	

    public function allPosts(Request $request)
    {
        
        $columns = array( 
                            0 =>'id', 
                            1 =>'brand_name',
                            2=> 'model_name',
                            3=> 'color',
                            4=> 'description',
                            5=> 'fuel_type',
                            6=> 'car_images',
                            7=> 'created_at',
                            8=> 'id',
                        );
  
        $totalData = Car::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = Car::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts =  Car::where('id','LIKE',"%{$search}%")
                            ->orWhere('brand', 'LIKE',"%{$search}%")
                            ->orWhere('model', 'LIKE',"%{$search}%")
                            ->orWhere('color', 'LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->orWhere('fuel_type', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Car::where('id','LIKE',"%{$search}%")
                             ->orWhere('brand', 'LIKE',"%{$search}%")
                             ->orWhere('model', 'LIKE',"%{$search}%")
                             ->orWhere('color', 'LIKE',"%{$search}%")
                             ->orWhere('description', 'LIKE',"%{$search}%")
                             ->orWhere('fuel_type', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
               

                $nestedData['id'] = $post->id;
                $nestedData['brand_name'] = $post->brand;
                $nestedData['model_name'] = $post->model;
                $nestedData['color'] = $post->color;
                $nestedData['description'] = $post->description;
                $nestedData['fuel_type'] = $post->fuel_type;
                $nestedData['car_images'] = "<img src='img_upload/car_images/".$post->image."' width='50' height='50'>";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['action'] = '<a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$post->id.'" data-brand="'.$post->brand.'" data-modal_name="'.$post->model.'" data-color="'.$post->color.'" data-description="'.$post->description.'" data-image="img_upload/car_images/'.$post->image.'" data-fule="'.$post->fuel_type.'"><i class="fa fa-pencil"></i> Edit </a>   <a href="#" class="btn btn-danger btn-xs" onclick="car_delete('. $post->id.')"><i class="fa fa-trash-o"></i> Delete </a>  ';

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }


}
