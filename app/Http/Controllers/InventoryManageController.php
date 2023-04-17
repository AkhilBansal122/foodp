<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventory;
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
            $query =Inventory::where('id',1);
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

      //  dd($user);
        if(!is_null($user)){
            if($user->is_admin==2){
                $data= Inventory::where("user_id",auth()->user()->id)->get();
                return view('restaurent/inventory/create',compact('data'));
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
                'qty' => 'required',
                'qty' => 'required',
                'price' => 'required',
            ],
            [
                'qty.required' => 'Please Enter Qty in Number',
                'qtyo.required' => 'Please Enter Qty in Kg/Quintal/Ton',
                'price.required' => 'Please Enter Qty in Number',
            ]);

     
            $inventoryData = new Inventory;
            if(!empty($request->all())){
            $check= User::where('id',"!=",0);
                    
                    $InventoryData->user_id = $user->id;
                    
                  //  $InventoryData->icon = $icon;
                    
                        $inventoryData->user_id = $user->id;
                    
                        $inventoryData->title = $request->qty;
                        $inventoryData->title = $request->qtyo;   
                        $inventoryData->title = $request->price;        
                        if($InventoryData->save()){
                        $InventoryData->save();
                        return redirect('restaurent/Inventory')->with('success','Inventory Added Successfully');
                    }
                    else
                    {
                        return redirect('restaurent/Inventory')->with('error','Inventory Added Failed');
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
            if($user->is_admin==1){
                return view('admin/inventory/edit',compact('data'));
                }else if($user->is_admin==2){
                 return view('restaurent/inventory/edit',compact('data'));
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
                    'qty' => 'required',
                    'qtyo' => 'required',
                    'price' => 'required',
                ],
                [
                    'qty.required' => 'Please Enter Qty in Number',
                    'qtyo.required' => 'Please Enter Qty in Kg/Quintal/Ton',
                    'price.required' => 'Please Enter Qty in Number',
                ]);
         
        }

            if(!empty($request->all())){
                $inventoryData =  Inventory::find($request->id);
                 
                // $inventoryData->qty(num) = isset($request->qty(num)) ? $request->qty(num) :$inventoryData->qty(num);
                // $inventoryData->qty(k/q/t) = isset($request->qty(k/q/t)) ? $request->qty(k/q/t) :$inventoryData->qty(k/q/t);
                // $inventoryData->price = isset($request->price) ? $request->price :$inventoryData->price;
                $inventoryData->qty = isset($request->qty) ? $request->qty :$inventoryData->qty;
                $inventoryData->qtyo = isset($request->qtyo) ? $request->qty(k/q/t) :$inventoryData->qtyo;
                $inventoryData->price = isset($request->price) ? $request->price :$inventoryData->price;


                if($inventoryData->save()){
                    return redirect('restaurent/inventory')->with('success','Data updated Successfully');
                }
                else{
                    return redirect('restaurent/inventory')->with('error','Data updated Failed');
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
                $row['qty'] = isset($value->qty)? $value->qty:'-';
                $row['qtyo'] = isset($value->qtyo)? $value->qtyo:'-';
                $row['price'] = isset($value->price)? $value->price:'-';
               
                $edit = Helper::editAction(url('/restaurent/inventory/edit/'),encrypt($value->id));
                
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
