@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Start Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Permintaan</h4>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Add Request Button -->
                        <a href="{{ route('request.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float: right;">
                            <i class="fas fa-plus-circle"></i> Form Permintaan
                        </a>
                        <br><br>

                        <h4 class="card-title">Daftar Semua Permintaan</h4>

                        <!-- Data Table -->
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" 
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Deskripsi</th>
                                    <th>Rincian</th>
                                    <th>Cetak BPP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allData as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <a href="{{ route('requests.detail', $item->id) }}" class="btn btn-primary">
                                                Rincian Permintaan
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('request.print.pdf', $item->id) }}" class="btn btn-info waves-effect waves-light ms-2">
                                                Cetak BPP
                                            </a>
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
