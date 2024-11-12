@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Report Permintaan Barang Pegawai</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <strong>Customer Paid Report</strong>
                            </div>
                        </div> <!-- // end row  -->

                        <!--  /// show_paid (visible by default) -->
                        <div class="show_paid">
                            <form method="GET" action="{{ route('customer.wise.paid.report') }}" id="myForm" target="_blank">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label>Customer Name</label>
                                        <select name="customer_id" class="form-select select2">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $cus)
                                                <option value="{{ $cus->id }}">{{ $cus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4" style="padding-top: 28px;">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--  /// End show_paid -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection
