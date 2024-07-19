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
                        <li class="breadcrumb-item active">Add Product</li>
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
                            <h3 class="card-titile">Add Product Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <a href="{{ $urlBack }}" class="btn btn-sm btn-outline-secondary"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>
                                        Back</a>
                                    @if (is_null($sampleStatus))
                                        <button class="btn btn-outline-success btn-sm" id="btn-send">Send Request
                                            Sample</button>
                                    @endif
                                </div>
                            </div>
                            <div class="m-1">
                                <form action="javascript:;" method="post" id="form-add-{{ $javascriptID }}">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for=sample-id"">Sample ID</label>
                                            <input type="text" name="sample_id" class="form-control" id="sample-id"
                                                value="{{ $sampleID }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="product">Product</label>
                                            <select name="product" id="product" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="qty">Qty</label>
                                            <input type="text" name="qty" id="qty" class="form-control"
                                                placeholder="eg: 1bottle @ 500ml"></input>
                                        </div>
                                        <div class="col">
                                            <label for="label-name">Label name</label>
                                            <input type="text" name="label_name" id="label-name" class="form-control"
                                                placeholder="label name">
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-center">
                                        @if (is_null($sampleStatus))
                                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        @endif
                                        <button type="reset" class="btn btn-outline-danger mr-2">Discard</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- spinner -->
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only text-primary">Loading...</span>
                </div>
            </div>
            <!-- spinner -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-titile">Table Product Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <button class="btn btn-sm btn-danger btn-delete" id="btn-delete" disabled><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete Product</button>
                                </div>
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-{{ $javascriptID }}" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 15px;">#</th>
                                            <th style="width: 10px;">No</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Label</th>
                                            <th style="">Action</th>
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

    <!-- modal add product start-->
    <div class="modal fade" id="modal-edit-{{ $javascriptID }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-edit-{{ $javascriptID }}">
                        @csrf
                        <div class="form-group row">
                            <label for="product">Product</label>
                            <select name="product" id="product-edit" class="form-control"></select>
                        </div>
                        <div class="form-group row">
                            <label for="qty">Qty</label>
                            <input type="text" name="qty" id="qty-edit" class="form-control"
                                placeholder="eg: 1bottle @ 500ml"></input>
                        </div>
                        <div class="form-group row">
                            <label for="label-name">Label name</label>
                            <input type="text" name="label_name" id="label-name-edit" class="form-control"
                                placeholder="label name">
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-success">Update</button>
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
    <!-- modal add product end-->
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
        ModuleFn = @json($moduleFn)
    </script>
    <script src="{{ asset('dist/js/sample-request/sample-requests/create-sample-product.min.js?q=') . time() }}"></script>
@endpush
