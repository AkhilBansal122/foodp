<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryTracking;
use App\Models\Product;
use File;
use DataTables;
use Str;
use Validator;
use Helper;
class InventoryManageController extends Controller
{
    public function index(){
        
        $user = auth()->user();
        if(!is_null($user)){
            $query =Inventory::where('id','!=',0);
            if($user->is_admin==2)
            {
                $query->where(['user_id'=>$user->id]);
            }
            $data =$query->get();
            return view('restaurent/inventory/index',compact('data'));
        }else{
            return redirect('login');
        }
    }

    public function create(){
        $user = auth()->user();
        $product = Product::where('status','Active')->get();

      //  dd($user);
        if(!is_null($user)){
            if($user->is_admin==2){
             //   $data= Inventory::where("user_id",auth()->user()->id)->get();
                return view('restaurent/inventory/create',compact('product'));
            }
        }else{
            return redirect('login');
        }
    }
    
    public function store(Request $request){
   
        //   dd($request->all());
        $user = auth()->user();
    //   dd($user);
        if(!is_null($user)){
            

            $request->validate([
                'product_id' => 'required',
                'qty_num' => 'required',
                'qty_opt' => 'required',
                'price' => 'required',
            ],
            [
                'product_id.required' => 'Please Enter Select Product',
                'qty_num.required' => 'Please Enter Qty in Number',
                'qty_opt.required' => 'Please Enter Qty in Kg/Quintal/Ton',
                'price.required' => 'Please Enter Qty in Number',
            ]);

     
            $inventoryData = new Inventory;
            if(!empty($request->all())){
            $check= User::where('id',"!=",0);
                    
                    $InventoryData->product_id = $request->product_id;
                    
                  //  $InventoryData->icon = $icon;
                    
                        $inventoryData->user_id = $user->id;
                    
                        $inventoryData->qty_num = $request->qty_num;
                        $inventoryData->qty_opt = $request->qty_opt;   
                        $inventoryData->price = $request->price;        
                        if($inventoryData->save()){
                        $inventoryData->save();
                        $InventoryTracking = new InventoryTracking();
                        $InventoryTracking->product_id = $request->product_id;
                        $InventoryTracking->user_id = $user->id;
                        $InventoryTracking->cr_qty = $request->qty_num;
                        $InventoryTracking->save();
                        
                        return redirect('restaurent/inventory_manage')->with('success','Inventory Added Successfully');
                    }
                    else
                    {
                        return redirect('restaurent/inventory_manage')->with('error','Inventory Added Failed');
                    }
                }
        
    }else{
            return redirect('login');
        }
    }

    public function edit($id){
        $user = auth()->user();
        if(!is_null($user)){
           $data = Inventory::find(decrypt($id));
            if(!is_null($data)){
                $product = Product::where('status','Active')->get();

            if($user->is_admin==1){
                return view('admin/inventory/edit',compact('data','product'));
                }else if($user->is_admin==2){
                 return view('restaurent/inventory/edit',compact('data','product'));
                }
            }
        }
        else{
            return redirect('login');
        }
    }

    public function update(Request $request){
        $user = auth()->user();
        if(!is_null($user)){
            if($user->id_admin==2)
            {
                $request->validate([
                    'product_id' => 'required',
                    'qty_num' => 'required',
                    'qty_opt' => 'required',
                    'price' => 'required',
                ],
                [
                    'product_id.required' => 'Please Select Product',
                   
                    'qty_num.required' => 'Please Enter Qty in Number',
                    'qty_opt.required' => 'Please Enter Qty in Kg/Quintal/Ton',
                    'price.required' => 'Please Enter Qty in Number',
                ]);
         
        }

            if(!empty($request->all())){
                $inventoryData =  Inventory::find($request->id);
                $inventoryData->product_id = isset($request->product_id) ? $request->product_id :$inventoryData->product_id;
                  
                $inventoryData->qty_num = isset($request->qty_num) ? $request->qty_num :$inventoryData->qty_num;
                $inventoryData->qty_opt = isset($request->qty_opt) ? $request->qty_opt :$inventoryData->qty_opt;
                $inventoryData->price = isset($request->price) ? $request->price :$inventoryData->price;


                if($inventoryData->save()){
                    return redirect('restaurent/inventory_manage')->with('success','Data updated Successfully');
                }
                else{
                    return redirect('restaurent/inventory_manage')->with('error','Data updated Failed');
                }
            }
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
        //    $status = $request['status'] ?? null;
          //  $start_date = $request['start_date'] ?? null ;
            //$end_date = $request['end_date'] ?? null; 
          //  echo auth()->user()->id;
           // die;
            $querydata = Inventory::where('user_id',auth()->user()->id)->latest();
            if (!is_null($search) && !empty($search)) {
                $querydata->where(function($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%');
                });
            }
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
                $row['product_id'] = isset($value->product_id)? $value->product_id:'-';
                
                $row['qty_num'] = isset($value->qty_num)? $value->qty_num:'-';
                $row['qty_opt'] = isset($value->qty_opt)? $value->qty_opt:'-';
                $row['price'] = isset($value->price)? $value->price:'-';
               
                $edit = Helper::editAction(url('/restaurent/inventory_manage/edit/'),encrypt($value->id));
                
                $sel = "<select class='form-control statusAction' data-path=".route('restaurent.inventory_manage.status_change')."  data-value=".$value->status." data-id = ".$value->id."  >";
                $sel .= "<option value='Active' " . ((isset($value->status) && $value->status == 'Active') ? 'Selected' : '') . ">Active</option>";
                $sel .= "<option value='Inactive' " . ((isset($value->status) && $value->status == 'Inactive') ? 'Selected' : '') . ">Inactive</option>";
                $sel .= "</select>";

            $row['status'] =$sel;
                $row['action'] = Helper::action($edit);
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

    public function status_change(Request $request){
        //   dd($request->all());
           $change     =   $this->changeStatus('Inventory',$request);
           if($change){
   
               return ['status'=>1,'type'=>'success','message'=>"Status Change Successfully"];
           }else{
               return ['status'=>0,'type'=>'danger','message'=>"Status Change Failed"];
           }
       }
}
