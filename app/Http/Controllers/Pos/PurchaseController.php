<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;


class PurchaseController extends Controller
{
    public function PurchaseAll(){

        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.purchase.purchase_all',compact('allData'));

    } // End Method 


    public function PurchaseAdd(){

        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();
        return view('backend.purchase.purchase_add',compact('supplier','unit','category'));

    } // End Method 


    public function PurchaseStore(Request $request){

    if ($request->category_id == null) {

       $notification = array(
        'message' => 'Sorry you do not select any item', 
        'alert-type' => 'error'
    );
    return redirect()->back( )->with($notification);
    } else {

        $count_category = count($request->category_id);
        for ($i=0; $i < $count_category; $i++) { 
            $purchase = new Purchase();
            $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
            $purchase->purchase_no = $request->purchase_no[$i];
            $purchase->supplier_id = $request->supplier_id[$i];
            $purchase->category_id = $request->category_id[$i];

            $purchase->product_id = $request->product_id[$i];
            $purchase->buying_qty = $request->buying_qty[$i];
            $purchase->unit_price = $request->unit_price[$i];
            $purchase->buying_price = $request->buying_price[$i];
            $purchase->description = $request->description[$i];

            $purchase->created_by = Auth::user()->id;
            $purchase->status = '0';
            $purchase->save();
        } // end foreach
    } // end else 

    $notification = array(
        'message' => 'Data Save Successfully', 
        'alert-type' => 'success'
    );
    return redirect()->route('purchase.all')->with($notification); 
    } // End Method 


    public function PurchaseDelete($id){

        Purchase::findOrFail($id)->delete();

         $notification = array(
        'message' => 'Purchase Iteam Deleted Successfully', 
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification); 

    } // End Method 


    public function PurchasePending(){

        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('backend.purchase.purchase_pending',compact('allData'));
    }// End Method 


    public function PurchaseApprove($id){

        $purchase = Purchase::findOrFail($id);
        $product = Product::where('id',$purchase->product_id)->first();
        $purchase_qty = ((float)($purchase->buying_qty))+((float)($product->quantity));
        $product->quantity = $purchase_qty;

        if($product->save()){

            Purchase::findOrFail($id)->update([
                'status' => '1',
            ]);

             $notification = array(
        'message' => 'Status Approved Successfully', 
        'alert-type' => 'success'
          );
    return redirect()->route('purchase.all')->with($notification); 

        }

    }// End Method 


    public function DailyPurchaseReport(){
        return view('backend.purchase.daily_purchase_report');
    }// End Method 


    public function DailyPurchasePdf(Request $request){

        $sdate = date('Y-m-d',strtotime($request->start_date));
        $edate = date('Y-m-d',strtotime($request->end_date));
        $allData = Purchase::whereBetween('date',[$sdate,$edate])->where('status','1')->get();


        $start_date = date('Y-m-d',strtotime($request->start_date));
        $end_date = date('Y-m-d',strtotime($request->end_date));
        return view('backend.pdf.daily_purchase_report_pdf',compact('allData','start_date','end_date'));


    }// End Method 

    public function viewPDF(Request $request)
    {
        // Retrieve start and end dates from the query string; default to today if not provided
    $start_date = $request->query('start_date', date('Y-m-d'));
    $end_date = $request->query('end_date', date('Y-m-d'));

    // Format dates for querying and ensure the date range is consistent
    $sdate = date('Y-m-d', strtotime($start_date));
    $edate = date('Y-m-d', strtotime($end_date));

    // Query the purchases within the specified date range and status
    $allData = Purchase::whereBetween('date', [$sdate, $edate])
                        ->where('status', '1')
                        ->get();

     // Load the view with purchase data, start, and end dates
     $pdf = Pdf::loadView('pdf.purcase', compact('allData', 'start_date', 'end_date'));

     // Download the PDF with a specified filename format
     return $pdf->download('daily_purchase_report_' . $start_date . '_to_' . $end_date . '.pdf');

   

    }

    public function viewWord(Request $request)
    {
         // Ambil tanggal mulai dan tanggal akhir dari query string
    $start_date = $request->query('start_date', date('Y-m-d'));
    $end_date = $request->query('end_date', date('Y-m-d'));

    // Format tanggal untuk query database
    $sdate = date('Y-m-d', strtotime($start_date));
    $edate = date('Y-m-d', strtotime($end_date));

    // Query data pembelian berdasarkan rentang tanggal dan status
    $allData = Purchase::whereBetween('date', [$sdate, $edate])
                        ->where('status', '1')
                        ->get();

    // Buat instance PHPWord
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Menambahkan baris untuk kop surat (logo kiri, alamat kanan)
    $table = $section->addTable([
        'borderSize' => 0,  // Tidak ada border pada tabel kop surat
        'cellMargin' => 80, // Spasi antara isi dan border sel
    ]);

    // Baris pertama untuk logo dan alamat
    $table->addRow();
    // Kolom pertama untuk logo
    $table->addCell(3000, ['valign' => 'center'])->addImage(public_path('logo/pa-cilegon.png'), [
        'width' => 100, 
        'height' => 100
    ]);
    // Kolom kedua untuk alamat
    $table->addCell(10000, ['valign' => 'center'])->addText(
        "MAHKAMAH AGUNG REPUBLIK INDONESIA\nPENGADILAN AGAMA CILEGON KELAS 1B\nKompleks Perkantoran Sukmajaya Mandiri,\nJalan Jenderal Ahmad Yani Kav.5, Sukmajaya, Kec. Jombang,\nKota Cilegon, Banten 42411", 
        ['bold' => true, 'size' => 12], 
        ['align' => 'left']
    );

    $section->addTextBreak(1); // Jarak antar paragraf

    // Tambahkan Judul dan Rentang Tanggal
    $section->addText("Laporan: Rencana Anggaran Biaya (RAB)", ['bold' => true, 'size' => 16], ['align' => 'center']);
    $section->addText("Tanggal: " . $sdate . " sampai " . $edate, ['size' => 12], ['align' => 'center']);
    $section->addTextBreak(1); // Jarak antar paragraf

    // Tambahkan Tabel untuk Data Pembelian
    $table = $section->addTable([
        'borderSize' => 6,
        'borderColor' => '999999',
        'cellMargin' => 80,
    ]);

    // Header tabel
    $table->addRow();
    $table->addCell(2000)->addText("No.");
    $table->addCell(4000)->addText("Uraian Pekerjaan");
    $table->addCell(2000)->addText("Satuan");
    $table->addCell(2000)->addText("Volume");
    $table->addCell(3000)->addText("Harga Satuan (Rp)");
    $table->addCell(3000)->addText("Jumlah (Rp)");

    // Tambahkan data ke dalam tabel
    $total_sum = 0;
    foreach ($allData as $key => $purchase) {
        $table->addRow();
        $table->addCell(2000)->addText($key + 1);
        $table->addCell(4000)->addText($purchase->product->name);
        $table->addCell(2000)->addText($purchase->product->unit->name);
        $table->addCell(2000)->addText($purchase->buying_qty);
        $table->addCell(3000)->addText("Rp. " . number_format($purchase->unit_price, 0, ',', '.'));
        $table->addCell(3000)->addText("Rp. " . number_format($purchase->buying_price, 0, ',', '.'));

        $total_sum += $purchase->buying_price;
    }

    // Tambahkan total harga
    $table->addRow();
    $table->addCell(9000, ['colspan' => 5])->addText("Total Harga");
    $table->addCell(3000)->addText("Rp. " . number_format($total_sum, 0, ',', '.'));

    // Menambahkan keterangan dan tanggal (di bawah tabel)
    $section->addTextBreak(1);
    $section->addText("Keterangan:");
    $section->addText("Tanggal dibuat: " . date('Y-m-d'));

    // Menambahkan Tanda Tangan dan Keterangan
    $section->addTextBreak(1);

    // Tabel tanda tangan dengan border 0
    $table2 = $section->addTable([
        'borderSize' => 0,  // Tidak ada border pada tabel tanda tangan
        'cellMargin' => 100,
    ]);

    // Baris 1 - Tanda tangan Bendahara dan Bendahara Barang
    $table2->addRow();
    $table2->addCell(4500)->addText("Bendahara Biaya Proses/ATK Penyelesaian Perkara", ['align' => 'center']);
    $table2->addCell(4500)->addText("Bendahara Barang Biaya Proses/ATK", ['align' => 'center']);
    
    // Baris 2 - Nama Tanda Tangan
    $table2->addRow();
    $table2->addCell(4500)->addText("Astriani Lantuka, A.Md. Kep., S.H.", ['align' => 'center', 'bold' => true, 'underline' => true]);
    $table2->addCell(4500)->addText("Uchtina Dewi", ['align' => 'center', 'bold' => true, 'underline' => true]);

    // Baris 3 - Tanda tangan Pejabat Pengelola dan Pejabat Pembuat Komitmen
    $table2->addRow();
    $table2->addCell(4500)->addText("Pejabat Pengelola Biaya Proses", ['align' => 'center']);
    $table2->addCell(4500)->addText("Pejabat Pembuat Komitmen Biaya Proses", ['align' => 'center']);
    
    // Baris 4 - Nama Tanda Tangan
    $table2->addRow();
    $table2->addCell(4500)->addText("Hikmah Nurmala, S.H., MH", ['align' => 'center', 'bold' => true, 'underline' => true]);
    $table2->addCell(4500)->addText("Wadihah, S.H.I.", ['align' => 'center', 'bold' => true, 'underline' => true]);

    // Simpan file ke server sementara
    $filePath = storage_path('app/public/daily_report_with_logo_and_address.docx');
    $phpWord->save($filePath, 'Word2007');

    // Download file
    return response()->download($filePath)->deleteFileAfterSend(true);
    }




}
  