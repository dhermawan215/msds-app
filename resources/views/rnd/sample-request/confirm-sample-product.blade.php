@extends('layouts.app')
@section('custom_css')
    <style>
        .select2 {
            width: 100% !important;
        }

        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        .img-preview {
            display: flex;
            flex-wrap: wrap;
        }

        .img-preview img {
            margin: 5px;
            width: 75px;
            height: 75px;
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
                        <li class="breadcrumb-item active">Confirm Sample Request Product</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-titile">Confirm Sample Request Product Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="ml-1">
                                <a href="{{ $homeUrl }}" class="btn btn-sm btn-outline-danger"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                    <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                </button>

                            </div>
                            <div class="m-1">
                                <b>Sample ID: {{ $sampleID }}</b>, Please confirm and fill the batch/ghs the sample
                                request product bellow:
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-{{ $javascriptID }}" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Label</th>
                                            <th>Pic/Creator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>

            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>

    <!-- modal asign sample start-->
    <div class="modal fade" id="modal-add-sample-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Add Sample Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-add-sample-detail">
                        @csrf
                        <div class="form-group row">
                            <label for="name">Batch Type</label>
                            <select name="batch_type" id="batch-type" class="form-control">
                                <option selected value="">-Select Batch Type-</option>
                                <option value="PROD">PRODUCTION</option>
                                <option value="LAB">LAB</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="batch-number">Batch Number</label>
                            <input type="text" name="batch_number" id="batch-number" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="product-remarks">Product Remarks</label>
                            <input type="text" name="product_remarks" id="product-remarks" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="released-by">Released By</label>
                            <select name="released_by" id="released-by" class="form-control">
                                <option value="0">-Select Released-</option>
                                <option value="Research & Development">Research & Development</option>
                                <option value="Warehouse">Warehouse</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="batch-number">Qty</label>
                            <input type="text" name="qty" id="qty" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="batch-number">Manufacture Date</label>
                            <input type="date" name="manufacture_date" id="manufacture-date" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="expired-date">Expired Date</label>
                            <input type="date" name="expired_date" id="expired_date" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="ghs">GHS Label</label>
                            <select name="ghs[]" id="ghs" class="form-control"></select>
                        </div>
                        <div class="form-group row">
                            <div class="img-preview" id="ghs-preview"></div>
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal asign sample end-->
@endsection
@push('custom_js')
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        var sampleID = '{{ $sampleID }}';
    </script>
    <script src="{{ asset('dist/js/rnd/sample-request/sample-product-confirm.min.js?q=') . time() }}"></script>
@endpush
