<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerQueryController extends Controller
{
    public function query(){
        return view('restaurent.customerquery');
    }
}
