<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Auth;
use Illuminate\Support\Carbon;
use Image; 

class EmployeeController extends Controller
{
    public function EmployeeAll(){

        $employees = Customer::latest()->get();
        return view('backend.employee.employee_all',compact('employees'));

   } // End Method
}
