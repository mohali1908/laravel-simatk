@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Daftar Pengajuan</h4>

                                     

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                  

                    <h4 class="card-title">Daftar Pengajuan </h4>
                    

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Pengajuan</th> 
                            <th>Tanggal </th>
                            <th>Supplier</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th> 
                            <th>Qty</th> 
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </thead>


                        <tbody>
                        	 
                        	@foreach($allData as $key => $item)
            <tr>
                <td> {{ $key+1}} </td>
                <td> {{ $item->purchase_no }} </td> 
                <td> {{ date('d-m-Y',strtotime($item->date))  }} </td> 
                 <td> {{ $item['supplier']['name'] }} </td> 
                 <td> {{ $item['category']['name'] }} </td> 
                 <td> {{ $item['product']['name'] }} </td> 
                 <td> {{ $item->buying_qty }} </td>
                 <td>Rp. {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                 <td>Rp. {{ number_format($item->buying_price, 0, ',', '.') }}</td> 

                 <td> 
                    @if($item->status == '0')
                    <span class="btn btn-warning">Pending</span>
                    @elseif($item->status == '1')
                    <span class="btn btn-success">Approved</span>
                    @endif
                     </td> 

                <td> 
@if($item->status == '0')
<a href="{{ route('purchase.approve',$item->id) }} " class="btn btn-danger sm" title="Approved" id="ApproveBtn">  <i class="fas fa-check-circle"></i> </a>
@endif
                </td>
               
            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        
                     
                        
                    </div> <!-- container-fluid -->
                </div>
 

@endsection