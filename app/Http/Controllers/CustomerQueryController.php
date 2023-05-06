<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Contact;
use Auth;
use Mail;
class CustomerQueryController extends Controller
{
    public function index(){
        $users = Contact::where(['user_id'=>auth()->user()->id])->get();;
        return view('manager/customerquery/index',['users'=>$users]);
    }
    public function SendMail(Request $request){
        
       // dd($request->all());

        $contact = Contact::where(["id"=>$request->record_id])->first();
        $contact->reply =$request->reply ;
        $email = $contact->email;
        $subject = $contact->subject;
        
        $username = $contact->name;
       $data = array('subject'=>$contact->subject,'reply'=>$request->reply,"username"=>$username,"email"=>$email);
          Mail::send('email/demomail', $data, function($message) {
         $message->to($data[0]['email'], "")->subject
            ($subject);
         $message->from(config('setting.MAIL_FROM_ADDRESS'));
         return back()->with('success',"Mail send Successfully");
      });
    }
}
