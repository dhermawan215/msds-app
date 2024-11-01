@extends('layouts.app')
@section('custom_css')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Sample Request</li>
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-titile">Edit Customer Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <a href="{{ $urlBack }}" class="btn btn-sm btn-outline-secondary"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>
                                        Back</a>
                                </div>
                            </div>
                            <div class="m-1">
                                <form action="javascript:;" method="post" id="form-{{ $javascriptID }}">
                                    @csrf
                                    <input type="hidden" name="sval" id="sval">
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="customer">Customer</label>
                                            <select name="c" id="customer" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="customer-pic">Customer PIC</label>
                                            <select name="customer_pic" id="customer-pic" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="customer-address">Delivery Address</label>
                                            <select name="delivery_address" id="customer-address"
                                                class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button type="reset" class="btn btn-outline-danger mr-2">Discard</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- /.col -->
            </div>

            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
@endsection
@push('custom_js')
    <script>
        var sampleID = '{{ $sample }}';
    </script>
    <script src="{{ asset('dist/js/sample-request/sample-requests/edit-sample-customer.min.js?q=') . time() }}"></script>
@endpush
