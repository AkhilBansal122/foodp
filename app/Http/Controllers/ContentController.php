<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Str;
class ContentController extends Controller
{
    public function index()
    {
        $data = Content::latest()->get();
        if(!empty($data))
        {
            foreach($data  as $value)
            {
                $value->description  = decrypt($value->description);
            }
        }
       
        return view('restaurent/content/index',compact('data'));
    }
    
    public function edit($id)
    {
       $data= Content::where("id",decrypt($id))->first();
       if(!empty($data))
       {
        $data->description  = decrypt($data->description);

       }
       return view('restaurent/content/edit',compact('data'));
    }

    public function update(Request $request){
       
        $content = Content::findOrFail($request->id);
        $content->title =  isset($request->title)  ? $request->title : $content->title;
        $content->description =  isset($request->description)  ? encrypt($request->description)  : $content->description;
        $content->slug= isset($request->title) ?  Str::Slug($request->title) : $content->slug; 

        
        if($content->save()){
            return redirect('restaurent/content')->with("msg","Content Updated Successfully");
        }
        else{
            return redirect('restaurent/content')->with("msg","Content Updated Failed");
        }
    }

    public function view($id)
    {
       $data= Content::where("id",decrypt($id))->first();
       if(!empty($data))
       {
        $data->description  = decrypt($data->description);
       }
       return view('restaurent/content/view',compact('data'));
    }
    

    public function status_change(Request $request)
    {
        $getData= Content::findOrFail($request->id);
        if(!empty($getData) && !empty($request->status))
        {
            $getData->status = $request->status;
            if($getData->update())
            {
                return response()->json(['status'=>true,"data"=>"Status Change Successfully"]);
            }
        }
    }
}
