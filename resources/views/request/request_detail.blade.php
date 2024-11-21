@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Start Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Permintaan Detail</h4>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Back Button -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-rounded waves-effect waves-light">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Permintaan Detail</h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" 
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Produk</th>
                                    <th>Unit</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allData as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->unit_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            @if($item->status == '0')
                                                <span class="btn btn-warning">Pending</span>
                                            @elseif($item->status == '1')
                                                <span class="btn btn-success">Approved</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End Col -->
        </div> <!-- End Row -->

    </div> <!-- Container Fluid -->
</div>

@endsection
