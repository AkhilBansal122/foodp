<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tables;
use App\Models\Category;
use App\Models\SubCategories;

use App\Models\CartItem;
use App\Models\Cart;

use Auth;
use Session;
class WebsiteController extends Controller
{
    public function index($id){
        
        if(substr($id, 0, 4)==="TBL-")
        {
            Session::put("table_id",$id);
            if(is_null(auth()->user()))
            {
                return view('website.sign_up_in',compact('id'));
            }
            else if(auth()->user()->is_admin==5){
                auth()->user()->table_id = $id;
                $getChefData="";
                if(!empty($id)){
                 $getMenu = Tables::where('unique_id',$id)->first();
              
                  if(!is_null($getMenu)){
                        $manager_id = $getMenu->user_id;
                        $getChefData = User::where(['user_id'=>$manager_id,'is_admin'=>4,'status'=>"Active"])->get();
                        Session::put("restaurent_id",$getMenu->restaurent_id);
                        $getmenu= Category::where("user_id",$getMenu->restaurent_id)->where('status','Active')->take(3)->get(['id','name','image']);
                        if(!empty($getmenu)){
                            foreach($getmenu as $row){
                                $getSub = SubCategories::where("category_id",$row->id)->where('status','Active')->get(['id','name','category_id','discount','image','price','description']);
                                $row->sub_menu = $getSub;
                            }
                        }
                        $getMenu->menu  = $getmenu;
                    }
                    $restaurentName="";
                    return view('website.layout.main',compact('getMenu','getChefData','restaurentName'));
                }
            }
        }
        else{
            $restaurentName= $id;
           $getRestaurent = User::where("name",$restaurentName)->where('is_admin',2)->first();
           $manager_id = [];
           $getMenu =[];
           if(!is_null($getRestaurent)){
           $getAllManager= User::where("user_id",$getRestaurent->id)->where("is_admin",3)->where("status",'Active')->get(['id']);
            if(!empty($getAllManager)){
                foreach($getAllManager as $m){
                    array_push($manager_id,$m->id);
                }
            }

            
            $getmenus= Category::where("user_id",$getRestaurent->id)->where('status','Active')->take(3)->get(['id','name','image']);
            if(!empty($getmenus)){
                foreach($getmenus as $row){
                    $getSub = SubCategories::where("category_id",$row->id)->where('status','Active')->get(['id','name','category_id','discount','image','price','description']);
                    $row->sub_menu = $getSub;
                    array_push($getMenu,$row);
                }
            }
           } 
           $getChefData = User::whereIn('user_id',$manager_id)->where(['is_admin'=>4,'status'=>"Active"])->get();
            return view('website.layout.main',compact('getMenu','getChefData','restaurentName'));
        }
    }


    public function about($id){//restaurent Id

        $restaurentName="";
        if(substr($id, 0, 4)==="TBL-")
        {
            if(auth()->user()->is_admin==5){
                auth()->user()->table_id = $id;
            }
           Session::get('restaurent_id');
            $getMenu = Tables::where('unique_id',Session::get('table_id'))->first();
            $getChefData = User::where(['user_id'=>$getMenu->user_id,'is_admin'=>4,'status'=>"Active"])->get();
        }
        else{
            $restaurentName= $id;
            $getRestaurent = User::where("name",$restaurentName)->where('is_admin',2)->first();
            $manager_id = [];
            $getMenu =[];
            if(!is_null($getRestaurent)){
            $getAllManager= User::where("user_id",$getRestaurent->id)->where("is_admin",3)->where("status",'Active')->get(['id']);
             if(!empty($getAllManager)){
                 foreach($getAllManager as $m){
                     array_push($manager_id,$m->id);
                 }
             }
 
             
             $getmenus= Category::where("user_id",$getRestaurent->id)->where('status','Active')->take(3)->get(['id','name','image']);
             if(!empty($getmenus)){
                 foreach($getmenus as $row){
                     $getSub = SubCategories::where("category_id",$row->id)->where('status','Active')->get(['id','name','category_id','discount','image','price','description']);
                     $row->sub_menu = $getSub;
                     array_push($getMenu,$row);
                 }
             }
            } 
            $getChefData = User::whereIn('user_id',$manager_id)->where(['is_admin'=>4,'status'=>"Active"])->get();
        }
        return view('website.about',compact('getChefData','restaurentName'));
  
    }

    public function service($id){
        $restaurentName="";
        if(substr($id, 0, 4)==="TBL-")
        {
            if(auth()->user()->is_admin==5){
                auth()->user()->table_id = $id;
            }
        }
        else
        {
            $restaurentName = $id;

        }
       return view('website.service',compact('restaurentName'));
    }


    public function menu($id){
       
        $restaurentName="";
        if(substr($id, 0, 4)==="TBL-")
        {
            if(auth()->user()->is_admin==5){
                auth()->user()->table_id = $id;
            }
            $getMenus = Tables::where('unique_id',auth()->user()->table_id)->first();
        //    dd($getMenus);  
            $getMenu= Category::where("user_id",$getMenus->restaurent_id)->where('status','Active')->get(['id','name','image']);
            $getChefData = User::where(['user_id'=>$getMenus->manager_id,'is_admin'=>4,'status'=>"Active"])->get();
      
           if(!empty($getMenu)){
                foreach($getMenu as $row){
                   $getSub = SubCategories::where("category_id",$row->id)->where('status','Active')->get(['id','name','category_id','discount','image','price','description']);
                   $row->sub_menu = $getSub;
                }
            }
        }
        else
        {
            $restaurentName= $id;
           $getRestaurent = User::where("name",$restaurentName)->where('is_admin',2)->first();
           $manager_id = [];
           $getMenu =[];
           if(!is_null($getRestaurent)){
           $getAllManager= User::where("user_id",$getRestaurent->id)->where("is_admin",3)->where("status",'Active')->get(['id']);
            if(!empty($getAllManager)){
                foreach($getAllManager as $m){
                    array_push($manager_id,$m->id);
                }
            }

            $getmenus= Category::where("user_id",$getRestaurent->id)->where('status','Active')->take(3)->get(['id','name','image']);
            if(!empty($getmenus)){
                foreach($getmenus as $row){
                    $getSub = SubCategories::where("category_id",$row->id)->where('status','Active')->get(['id','name','category_id','discount','image','price','description']);
                    $row->sub_menu = $getSub;
                    array_push($getMenu,$row);
                }
            }
           } 
           $getChefData = User::whereIn('user_id',$manager_id)->where(['is_admin'=>4,'status'=>"Active"])->get();
            
        }
        return view('website.menu',compact('getMenu','getChefData','restaurentName'));
    }

    public function booking($id){
        if(auth()->user()->is_admin==5){
            auth()->user()->table_id = $id;
        }
        Session::get('table_id');
        Session::get('restaurent_id');
    
        return view('website.booking');
    }

    public function team($id){
        if(auth()->user()->is_admin==5){
            auth()->user()->table_id = $id;
        }
        Session::get('table_id');
        Session::get('restaurent_id');
        return view('website.team');
    }
    public function testimonial($id){
        if(auth()->user()->is_admin==5){
            auth()->user()->table_id = $id;
        }
    	return view('website.testimonial');
    }

    public function contact($id){
        $restaurentName="";
        if(substr($id, 0, 4)==="TBL-")
        {

        if(auth()->user()->is_admin==5){
            auth()->user()->table_id = $id;
        }
            // Session::get('table_id');
            // Session::get('restaurent_id');
        }

        return view('website.contact',compact('restaurentName'));
    }

    public function getsub_menu_by_menu_id(Request $request,$id){
        
        if(!empty($request->all())){
            $menu_id = $request->menu_id;
            $tab_id = $request->tab_id;
             $getSub = SubCategories::where("category_id",$menu_id)->where('status','Active')->get(['id','name','category_id','discount','image','price','description']);
          $respose="";
            if(!empty($getSub)){
                $respose.='<div id="tab-'.$tab_id.'"  class="tab-pane fade show p-0 active " >
                <div class="row g-4">';
                foreach($getSub as $i =>$row){
                    $respose.='<div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <img class="flex-shrink-0 img-fluid rounded" src="'.asset('public/').$row->image.'" alt="" style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>'.$row->name.'</span>
                                                    <span class="text-primary">'.$row->price.'</span>
                                                </h5>
                                                

                                                
                                                <small class="fst-italic">'.$row->description.'</small>
                                                
                                                <button type="button" class="btn btn-default btn-sm" onClick="add_to_cart("'.auth()->user()->table_id.'",'.$row->id.','.$row->price.',1);return false;">
                                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                                    <b> Add to Cart </b>
                                                </button>
                                            </div>
                                    </div>
                                </div>';
                   }
            }
            if(!empty($respose)){
                return response()->json(['status'=>true,"data"=>$respose]);
            }
            else{
                return response()->json(['status'=>false,"data"=>$respose]);

            }
        }
    }

    public function login(Request $request){
        $input = $request->all();
        $this->validate($request, [
            'emaillogin' => 'required|email',
            'loginpassword' => 'required',
        ],[
            'emaillogin.required'=>"Please enter email address",
            'loginpassword.required'=>"Please enter password"
        ]);
    
        $url = url('/')."/".$request->table_id;

        
        if(auth()->attempt(array('email' => $input['emaillogin'], 'password' => $input['loginpassword'])))
        {
            auth()->user()->table_id = $request->table_id;
          //  dd(auth()->user());
          //  Session::put('table_id',1111111);
            $url = url('/')."/".$request->table_id;

            if(!is_null(auth()->user()) && auth()->user()->status=='Active'){
                if (auth()->user()->is_admin == 5) {// customer
              
                    return redirect($url);
                }else{
                    return redirect()->back()
                    ->with('error','InAuthotize User');
                }}else{
               $this->logout($url);
               return redirect($url)
                ->with('error','InActive Your account please contact support team.');
            }
        }
        else
        { 
            return redirect($url)->with('error','Email-Address And Password Are Wrong.');
        }
        
    }
    //user signup data store in database
    public function user_signup_store(Request $request){
       
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile_number' => 'required|min:10|max:12',
            'email' =>'required|email|unique:users',
            'password' => 'required'
        ],[
            'firstname.required'=>"Please enter first name",
            'lastname.required'=>"Please enter last name",
            'mobile_number.required'=>"Please enter mobile number",
            'email.required'=>"Please enter email address",
            'password.required'=>"Please enter password"
        ]);
        
        $table_id = $request->table_id;
        $TablesData = Tables::where("unique_id",$table_id)->first();
       $branch_id=  $TablesData->get_manager->branch_id;

        $signup_store = new User;
        $signup_store->firstname = $request['firstname'];
        $signup_store->lastname = $request['lastname'];
        $signup_store->mobile_number = $request['mobile_number'];
        $signup_store->email = $request['email'];
        $signup_store->password = bcrypt($request['password']);
        $signup_store->upassword = $request['password'];
        $signup_store->is_admin = 5;
        $signup_store->name = $request->firstname .$request->lastname;
        $signup_store->branch_id = $branch_id;
      
        $signup_store->user_id = $TablesData->restaurent_id;
        $signup_store->save();
        $signup_store->unique_id = "CUS-000".$signup_store->id;
        $signup_store->save();
        return redirect()->back();
    }

    //thenkYou
    public function thenkYou(){
        $restaurentName="";
        return view('website.thanks',compact('restaurentName'));
      
    }
    public function logout(){
         Auth::Logout();
        return redirect('thenkYou');
    }

    //CartItem
    public function cartItem($id){
        
        if(auth()->user()->is_admin==5){
            auth()->user()->table_id = $id;
        }
        
        return view('website.cartItem',compact('id'));

    }   
    
    public function cartItemList(Request $request,$id){
        $result =[];
        if(auth()->user()->is_admin==5){
           $getCart = Cart::where("user_id",auth()->user()->id)->first();
           if($getCart){
            $getCartDetails = CartItem::where("user_id",auth()->user()->id,"cart_id",$getCart->cart_id)->get();
            
            foreach($getCartDetails as $r){
                $r->product_name = $r->productDetails->name;
                $r->catagory_name = $r->productDetails->menuDetails->name;
                $r->product_image =asset('public'). $r->productDetails->image;
            }

            $result['status'] = true;
            $result['data'] = $getCartDetails;
            $result['cart'] = $getCart;
            }   
            else{
            $result['status'] = false;
            $result['data'] = [];
            $result['cart'] = [];
           }
           return response()->json($result);

        }
    }


}