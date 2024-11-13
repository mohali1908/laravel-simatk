<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function RequestAll(){
        // $suppliers = Supplier::all();
        $requests = Supplier::latest()->get();
        return view('request.request_all',compact('requests'));
    } // End Method 
}
