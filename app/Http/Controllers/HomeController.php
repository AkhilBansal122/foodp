<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Orders;
use DB;
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
        if(!is_null(auth()->user())){
            $is_admin  =auth()->user()->is_admin;
            if($is_admin==1){
            $total_restaurent = User::where('is_admin',2)->count();
             $total_order= Orders::whereIn("branch_id",Branch::whereIn("user_id",User::where('is_admin',2)->get('id'))->get(['id']))->count();  
             $total_revenue= Orders::whereIn("branch_id",Branch::whereIn("user_id",User::where('is_admin',2)->get('id'))->get(['id']))->sum('final_amount');
             $data =[];

               foreach(User::where('is_admin',2)->get() as $row)
               {
                $row->total_order= Orders::whereIn("branch_id",Branch::where("user_id",$row->id)->get(['id']))->count();  
                     $row->total_revenue  =Orders::whereIn("branch_id",Branch::where("user_id",$row->id)->get(['id']))->sum('final_amount');
                    array_push($data,$row);
                }
              //  dd($data);
            //   $total_order=0;
                return view('admin/dashboard',compact('total_restaurent','total_order','total_revenue'));
            }
            else if($is_admin==2){
              $total_branch = Branch::where('user_id',auth()->user()->id)->count();
              $total_manager = User::where('user_id',auth()->user()->id)->where('is_admin',3)->count();
              $total_chef=  User::whereIn('user_id', User::select(['id'])->where(['is_admin'=> 3,'user_id'=>auth()->user()->id]))->where('is_admin', 4)->count();
              $total_order=0;
              return view('restaurent/dashboard',compact('total_branch','total_manager','total_chef','total_order'));
          }
          else if($is_admin==3){
               
            $total_chef = User::where('user_id',auth()->user()->id)->where('is_admin',4)->count();
            $total_order = Orders::where('branch_id',auth()->user()->branch_id)->count();
            $total_customer = User::where('is_admin',5)->count();
            return view('manager/dashboard',compact('total_chef','total_customer','total_order'));
        }
    }
}
public function restaurentGraphs(){
    if(!is_null(auth()->user())){
        $is_admin  =auth()->user()->is_admin;
        $result=[];
        if($is_admin==1){
             $data=  User::select(
                DB::raw("(COUNT(*)) as count"),
                DB::raw("MONTHNAME(created_at) as monthname")
                )
            ->whereYear('created_at', date('Y'))
            ->groupBy('monthname')
            ->get();
            $countData ="";
            if(!empty($data)){
                return response()->json(['status'=>true,"data"=>$data]);
            }
            else
            {
                return response()->json(['status'=>false,"data"=>$result]);
            }
        }
    }

}
public function restaurentGraph(Request $request){
    if($request->all()){
      
        $is_admin  =auth()->user()->is_admin;
        $result=[];
        if($is_admin==1){
            $type =$request->type;//1 for week 2 for month or 3 for year get all previous 6 month/week/year
            if($type ==1)
            {
                $users=   User::select(
                    DB::raw("(COUNT(*)) as y"),
                    DB::raw("MONTHNAME(created_at) as label"))
                    ->where('is_admin',2)
                    ->whereBetween('created_at', 
                        [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                    )  
                    ->groupBy('label')
                    ->orderBy('y','ASc')
                    ->get();
     

                    if(!is_null($users) && count($users)>0)
                    {
                    $status = true; 
                    $datas = $users;
                    }
                    else{
                    $datas = $users;
                    $status = false;
                    }
                    return response()->json(['status'=>$status,"data"=>$datas]);
          }

      if($type ==2)
      {

        $users = User::select(
          DB::raw("(COUNT(*)) as y"),
          DB::raw("MONTHNAME(created_at) as label")
        
        )
        ->where('is_admin',2)
        ->whereBetween('created_at',[Carbon::now()->subMonth(6), Carbon::now()])
        ->groupBy('label')
         // ->orderBy("MONTH(created_at)",'Asc')
        ->get();
          
        
          if(!is_null($users) && count($users)>0)
          {
            $status = true; 
            $datas = $users;
          }
          else{
            $datas = $users;
            $status = false;
          }
        //  dd($datas->toArray());
        return response()->json(['status'=>$status,"data"=>$datas]);
     }
      if($type ==3)
      {
        $users = User::select(
        DB::raw("(COUNT(*)) as y"),
        DB::raw("YEAR(created_at) as label")
        )
        ->where('is_admin',2)
        ->whereBetween('created_at',[Carbon::now()->subYear(6), Carbon::now()])
        ->groupBy('label')
        ->get();
        if(!is_null($users) && count($users)>0)
        {
         $status = true; 
         $datas = $users;
        }
        else{
          $datas = $users;
          $status = false;
        }
        return response()->json(['status'=>$status,"data"=>$datas]);
      }
    }
    }
  }
}
