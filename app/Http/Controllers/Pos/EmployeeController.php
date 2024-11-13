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

        $employees = Employee::latest()->get();
        return view('backend.employee.employee_all',compact('employees'));

   } // End Method

   public function EmployeeAdd(){
    return view('backend.employee.employee_add');
   }    // End Method

   public function EmployeeStore(Request $request){

    $image = $request->file('image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 343434.png
    Image::make($image)->resize(200,200)->save('upload/employee/'.$name_gen);
    $save_url = 'upload/employee/'.$name_gen;

    Employee::insert([
        'name' => $request->name,
        'unit' => $request->unit,
        'image' => $save_url ,
        'created_by' => Auth::user()->id,
        'created_at' => Carbon::now(),

    ]);

     $notification = array(
        'message' => 'Employee Inserted Successfully', 
        'alert-type' => 'success'
    );

    return redirect()->route('employee.all')->with($notification);

    } // End Method 

    public function EmployeeEdit($id){

        $employee = Employee::findOrFail($id);
        return view('backend.employee.employee_edit',compact('employee'));
 
     } // End Method


     public function EmployeeUpdate(Request $request){

        $employee_id = $request->id;
        if ($request->file('image')) {

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 343434.png
        Image::make($image)->resize(200,200)->save('upload/employee/'.$name_gen);
        $save_url = 'upload/employee/'.$name_gen;

        Employee::findOrFail($employee_id)->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'image' => $save_url ,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

         $notification = array(
            'message' => 'Employee Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('employee.all')->with($notification);
             
        } else{

        Employee::findOrFail($employee_id)->update([
            'name' => $request->name,
            'unit' => $request->unit, 
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

         $notification = array(
            'message' => 'Employee Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('employee.all')->with($notification);

        } // end else 

    } // End Method

    public function EmployeeDelete($id){

        $employees = Employee::findOrFail($id);
        $img = $employees->image;
        unlink($img);

        Employee::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Employee Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method




}
