<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryTracking;
use App\Models\Product;
use App\Models\InventoryRequest;
use File;
class WarehouseController extends Controller
{
    public function create(){
        $user = auth()->user();
        if(!is_null($user) && ($user->is_admin==2)){
            $data = User::where("user_id",$user->id)->where("is_admin",6)->first();
            return view('restaurent/warehouse/create',compact('data'));
        }else{
            return redirect('login');
        }
    }


    public function store(Request $request){
       // dd($request->all());
        $user = auth()->user();
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'aadhar_card' => 'required',
            'email' =>'required|email|unique:users,email,'.$user->id,
            'mobile_number' => 'required|numeric|digits:10',
            'other_mobile_number' => 'numeric|digits:10',
            'pen_card'=>'required'
        ],
        [
            'firstname.required' => 'Please Enter First Name.',
            'lastname.required' => 'Please Enter First Name.',
            'email.required' => 'Please Enter Mail.',
            'aadhar_card.required' => 'Please Aadhar Card.',
            'name.required' => 'Please Enter Restaurent Name',
            'mobile_number.required' => 'Please Enter Mobile Number'
        ]);

        $userData = new User;
        if(!is_null($user) && $user->is_admin==2)
        {
            if(!empty($request->all())){
                $check= User::where('email',$request->email);
            
                 $checkData = $check->count();
                if($checkData>0){
                    return redirect()->back()->with('error',''.$request->email. 'Already Exists');
                }
                else
                {
                    $path = public_path('upload/restaurent/warehouse/');
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    } 

                    $image="";
                    if($request->hasfile('image'))
                    {
                        $imageName = time().'.'.$request->image->extension();
                        $request->image->move($path, $imageName);
                        $image.='/upload/restaurent/warehouse/'.$imageName;
                    }  

                    $userData->image = $image;
                    $userData->firstname = $request->firstname;
                    $userData->lastname = $request->lastname;
                    $userData->email = $request->email;
                    $userData->pen_card = isset($request->pen_card)  ? $request->pen_card :'';
                    $userData->aadhar_card = isset($request->aadhar_card)  ? $request->aadhar_card :'';
                    $userData->mobile_number = isset($request->mobile_number)  ? $request->mobile_number :'';
                    $userData->password = bcrypt($request->password);
                    $userData->upassword = $request->password;
                    $userData->other_mobile_number = $request->other_mobile_number;
                    $userData->is_admin = 6;
                    $userData->user_id = $user->id;
                    $userData->local_address = isset($request->local_address) ?$request->local_address :'';
                    $userData->permanent_address = isset($request->permanent_address) ?$request->permanent_address :'';
                    if($userData->save()){
                        $userData->unique_id = "WHE-000".$userData->id;
                        $userData->save();
                        return redirect()->back()->with('success','Warehouse Registration Successfully');
                    }
                    else{
                        return redirect()->back()->with('error','Warehouse Registration Failed');
                    }
                }
            }
            else{
                return redirect()->back()->with('error','Plese Fill All Required Fields');
            }
        }
    }
    
    public function update(Request $request){
        $user = auth()->user();
        if(!is_null($user)){
            if($user->id_admin==2)
            {
                $validator=   $request->validate([
                    'firstname' => 'required',
                    'lname'=>'required',
                    'aadhar_card' => 'required|max:20|min:16',
                    'mobile_number' => 'required|max:12|min:10',
                    'local_address' => 'required',
                    'permanent_address' => 'required',
                    'password'=>'required',
                    'other_mobile_number'=>'required|max:12|min:10'
                ],
                [
                    'firstname.required' => 'Please Enter First Name',
                    'lastname.required' => 'Please Enter LastName',
                    'password.required' => 'Please Enter Password',
                    'aadhar_card.required'=>"Please Enter Aadhar Card",
    
                    'local_address.required'=>"Please Enter Local Address",
                    'permanent_address.required'=>"Please Enter Personal Address",
                    'mobile_number.required'=>"Please Enter Mobile Number",
                    'other_mobile_number.required'=>"Please Enter Other Mobile Number"
                ]);
                if($validator->fails()) {
                    return Redirect::back()->with('error',$validator);
                }
            }
            if(!empty($request->all())){
                $userData =  User::find($request->id);
                $path = public_path('upload/restaurent/warehouse/');
                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                } 
                $image="";
                if($request->hasfile('image'))
                {
                    if(!empty($userData->image))
                    {
                        unlink("public/".$userData->image);
                    }
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move($path, $imageName);
                    $image.='/upload/restaurent/warehouse/'.$imageName;
                    $userData->image = $image;
                }
                else{
                    $image = $userData->image;
                } 
          
            $userData->firstname = isset($request->firstname) ? $request->firstname : $userData->firstname;
            $userData->lastname = isset($request->lastname) ? $request->lastname : $userData->lastname;
            $userData->email = isset($request->email) ? $request->email : $userData->email;
            $userData->pen_card = isset($request->pen_card)  ? $request->pen_card :$userData->pen_card;
            $userData->aadhar_card = isset($request->aadhar_card)  ? $request->aadhar_card :$userData->aadhar_card;
            $userData->mobile_number = isset($request->mobile_number)  ? $request->mobile_number :$userData->mobile_number;
            $userData->other_mobile_number = isset($request->other_mobile_number)  ? $request->other_mobile_number :$userData->other_mobile_number;
            
            $userData->image = $image;
            $userData->password = bcrypt($request->password);
            $userData->upassword = $request->password;
            $userData->local_address = isset($request->local_address) ?$request->local_address :$userData->local_address;
            $userData->permanent_address = isset($request->permanent_address) ?$request->permanent_address :$userData->permanent_address;
            if($userData->save()){
                return redirect()->back()->with('success','Data updated Successfully');
            }
            else{
                return redirect()->back()->with('error','Data updated Failed');
            }
        }
    }
    else{
        return redirect('login');
    }
    }

    public function dashboard(){
        $user = auth()->user();
        if(!is_null($user)){
            return view('restaurent/warehouse/dashboard');
        }
        else{
            return redirect('login');
        }
    }
      
    public function data(Request $request){
        if ($request->ajax()) {
            $limit = $request->input('length');
            $start = $request->input('start');
           
            $search = $request['search'];
            $orderby = $request['order']['0']['column'];
            $order = $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw = $request['draw'];
            $querydata = Inventory::where('user_id',auth()->user()->user_id)->latest();
          
             $totaldata = $querydata->count();
             $response = $querydata->offset($start)
                    ->limit($limit)
                    ->get();
            if (!$response) {
                $data = [];
                
            } else {
                $data = $response;
            }
            $datas = array();
            $i = 1;

            foreach ($data as $value) {
                $id = $value->id;

                $row['id'] = $i;

                $row['product_name'] = $value->productDetails->product_name ?? '-';
                $row['total_cr'] = isset($value->total_cr)? $value->total_cr:0;
                $row['total_dr'] = isset($value->total_dr)? $value->total_dr:0;
                $row['total_available'] = isset($value->total_available)? $value->total_available:0;
                $row['qty_opt'] = isset($value->qty_opt)? $value->qty_opt:'-';
                $datas[] = $row;
            $i++;
            }
           // dd($datas);
            $return = [
                "draw" => intval($draw),
                "recordsFiltered" => intval($totaldata),
                "recordsTotal" => intval($totaldata),
                "data" => $datas
            ];
            return response()->json($return);
        }
    }

    public function manager_request(){
        $user = auth()->user();
        if(!is_null($user) && ($user->is_admin==3)){
            $product = Inventory::where("user_id",$user->user_id)->get();
           
            return view('manager/warehouse/create',compact('product'));
        }else{
            return redirect('login');
        }
    }
    public function request_store(Request $request){
        $user = auth()->user();
        if(!is_null($user) && ($user->is_admin==3)){
            $request->validate([
                'product_id' => 'required',
                'qty' => 'required|numeric',
            ],
            [
                'product_id.required' => 'Please Select Product.',
            ]);
            $InventoryRequest = new InventoryRequest;

             $InventoryRequest->user_id = $user->id;
            $InventoryRequest->product_id = $request->product_id;
            $InventoryRequest->qty = $request->qty;
            if($InventoryRequest->save()){
                return redirect()->back()->with('success','Request Send Successfully');
            }
            else{
                return redirect()->back()->with('error','Request Send Failed');
            }
        }else{
            return redirect('login');
        }
    }
}
