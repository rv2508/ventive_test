<?php

namespace App\Http\Controllers\Admin\mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Mobile;

class MobileController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

	public function mobile()
    {
    	$results = Mobile::orderBy('id', 'DESC')->get();

        return view('admin.mobile.mobile',compact('results'));
    }


    public function mobileSave(Request $request)
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

        $mobile = $request->all(); 
		unset($mobile['_token']);
        $mobile['created_at']=date('Y-m-d H:i:s');
        $mobile['updated_at']=date('Y-m-d H:i:s');
       	$image = $request->file('image');
       	if(!empty($image))
        {
	       	$path = public_path(). '/img_upload/mobile_images/';
	       	$filename = time() . '.' . $image->getClientOriginalExtension();
	       	$image->move($path, $filename);
	        unset($mobile['image']);
	       	$mobile['image'] = $filename;
	    }   	
		
			Mobile::insert($mobile);
		 	$results = Mobile::orderBy('id', 'DESC')->get();
			$mobile_data = view('admin.mobile.mobile_data',compact('results'))->render();
			return response()->json(['status' => 1,'mobile_data' => $mobile_data]);
    }

    public function mobileUpdate(Request $request)
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

        $mobile = $request->all(); 
		unset($mobile['_token']);
        $mobile['updated_at']=date('Y-m-d H:i:s');
       	$image = $request->file('image');
       	if(!empty($image))
        {
	       	$path = public_path(). '/img_upload/mobile_images/';
	       	$filename = time() . '.' . $image->getClientOriginalExtension();
	       	$image->move($path, $filename);
	        unset($mobile['image']);
	       	$mobile['image'] = $filename;
	    }   
			Mobile::where('id',$mobile['id'])->update($mobile);	
			
		 	//$results = Mobile::orderBy('id', 'DESC')->get();
			//$mobile_data = view('admin.mobile.mobile_data',compact('results'))->render();
			return response()->json(['status' => 1]);
    }
    public function mobileDelete(Request $request)
    {	
    	Mobile::where('id',$request->id)->delete();	
    //$results = Mobile::orderBy('id', 'DESC')->get();
		//$mobile_data = view('admin.mobile.mobile_data',compact('results'))->render();
		return response()->json(['status' => 1]);
    }   	

    public function allmobile(Request $request)
    {
        
        $columns = array( 
                            0 =>'id', 
                            1 =>'brand_name',
                            2=> 'model_name',
                            3=> 'color',
                            4=> 'description',
                            5=> 'os_type',
                            6=> 'mobile_images',
                            7=> 'created_at',
                            8=> 'id',
                        );
  
        $totalData = Mobile::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = Mobile::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts =  Mobile::where('id','LIKE',"%{$search}%")
                            ->orWhere('brand', 'LIKE',"%{$search}%")
                            ->orWhere('model', 'LIKE',"%{$search}%")
                            ->orWhere('color', 'LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->orWhere('os_type', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Mobile::where('id','LIKE',"%{$search}%")
                             ->orWhere('brand', 'LIKE',"%{$search}%")
                             ->orWhere('model', 'LIKE',"%{$search}%")
                             ->orWhere('color', 'LIKE',"%{$search}%")
                             ->orWhere('description', 'LIKE',"%{$search}%")
                             ->orWhere('os_type', 'LIKE',"%{$search}%")
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
                $nestedData['os_type'] = $post->os_type;
                $nestedData['mobile_images'] = "<img src='img_upload/mobile_images/".$post->image."' width='50' height='50'>";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['action'] = '<a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal1" data-id="'.$post->id.'" data-brand="'.$post->brand.'" data-modal_name="'.$post->model.'" data-color="'.$post->color.'" data-description="'.$post->description.'" data-image="img_upload/mobile_images/'.$post->image.'" data-fule="'.$post->os_type.'"><i class="fa fa-pencil"></i> Edit </a>   <a href="#" class="btn btn-danger btn-xs" onclick="mobile_delete('. $post->id.')"><i class="fa fa-trash-o"></i> Delete </a>  ';

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
