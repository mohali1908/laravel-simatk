<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;

use App\Models\Employee;
use App\Models\Request as RequestModel; 
use App\Models\RequestDetail;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RequestController extends Controller
{
    public function RequestAll(){
        $role = Auth::user()->role;
        
        $user_id = Auth::user()->id;

        // Jika Admin, ambil semua data, jika bukan, ambil data user_id saja
    if ($role === 'Admin') {
        $allData = RequestModel::orderBy('id')->get(); // Semua data untuk Admin
    } else {
        $allData = RequestModel::where('user_id', $user_id)->orderBy('id')->get(); // Data spesifik user
    }
        
        return view('request.request_all',compact('allData'));
    } // End Method 

    public function RequestDetail($id){

        $allData = DB::table('request_details')
        ->join('categories', 'request_details.category_id', '=', 'categories.id')
        ->join('products', 'request_details.product_id', '=', 'products.id')
        ->join('units', 'products.unit_id', '=', 'units.id') 
        ->select('request_details.*', 'categories.name as category_name', 'products.name as product_name', 'units.name as unit_name' )
        ->where('request_id', $id)
        ->orderBy('date')
        ->get();

        //$allData = RequestDetail::where('request_id', $id)->orderBy('date')->orderBy('id')->get();
        return view('request.request_detail',compact('allData'));
    }// End Method 

    public function RequestAdd()
    {
        $category = Category::all();
       
        $request_data = RequestModel::orderBy('id', 'desc' )->first();
        if ($request_data == null) {
            $firstReg = '0';
            $request_no = $firstReg + 1;
        } else {
            $request_data = RequestModel::orderBy('id', 'desc')->first()->request_no;
            $request_no = $request_data + 1;
        }
        $date = date('Y-m-d');
        return view('request.request_add', compact('request_no', 'category', 'date'));
    } // End Method


    public function RequestStore(Request $request)
    {
        if ($request->category_id == null) {

            $notification = array(
                'message' => 'Maaf Anda belum memilih apapun',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } 
                $req = new RequestModel();
                $req->user_id = Auth::user()->id;
                $req->date = date('Y-m-d', strtotime($request->date));
                $req->request_no = $request->request_no;
                $req->description = $request->description;
                $req->status = '0';
                

                DB::transaction(function () use ($request, $req) {
                    if ($req->save()) {
                        $count_category = count($request->category_id);
                        for ($i = 0; $i < $count_category; $i++) {

                            $req_details = new RequestDetail();
                            $req_details->date = date('Y-m-d', strtotime($request->date));
                            $req_details->request_id = $req->id;
                            $req_details->quantity = $request->qty[$i];
                            $req_details->category_id = $request->category_id[$i];
                            $req_details->product_id = $request->product_id[$i];
                            $req_details->status = '0';
                            $req_details->save();
                        }
                    }
                });
        
        $notification = array(
            'message' => 'Invoice Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('request.all')->with($notification);
    } // End Method


    public function viewPDF($id)
    {


    $allData = DB::table('request_details')
        ->join('products', 'request_details.product_id', '=', 'products.id')
        ->join('units', 'products.unit_id', '=', 'units.id')
        ->select('request_details.*',  'products.name as product_name', 'units.name as unit_name'  )
        ->where('request_id', $id)
        ->where('request_details.status', 1)
        ->orderBy('id')
        ->get();

    $userData = DB::table('request_details')
        ->join('requests', 'request_details.request_id', '=', 'requests.id')
        ->join('users', 'requests.user_id', '=', 'users.id') // Join ke tabel users melalui tabel requests
        ->select('request_details.*', 'users.name as user_name'  )
        ->where('request_id', $id)
        ->orderBy('id')
        ->get();

     // Load the view with purchase data, start, and end dates
     $pdf = Pdf::loadView('pdf.request', compact('allData','userData'));

     // Download the PDF with a specified filename format
     return $pdf->download('Bpp_' . $id . '.pdf');

    }
    public function RequestData(){

        $allData = DB::table('request_details')
        ->join('requests', 'request_details.request_id', '=', 'requests.id')
        ->join('users', 'requests.user_id', '=', 'users.id')
        ->join('products', 'request_details.product_id', '=', 'products.id')
        ->join('units', 'products.unit_id', '=', 'units.id')
        ->join('categories', 'request_details.category_id', '=', 'categories.id')
        ->select('request_details.*', 'categories.name as category_name', 'products.name as product_name', 'units.name as unit_name', 'users.name as users_name' )
        ->where('request_details.status',0)
        ->orderBy('date','desc')
        ->get();

        //$allData = RequestDetail::where('request_id', $id)->orderBy('date')->orderBy('id')->get();
        return view('request.request_pending',compact('allData'));
    }// End Method 



}
