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
                        <li class="breadcrumb-item active">Assign Sample Request Product</li>
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
                            <h3 class="card-titile">Assign Sample Request Product Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="ml-1">
                                <a href="{{ $homeUrl }}" class="btn btn-sm btn-outline-danger"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                    <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                </button>
                                <button class="btn btn-sm btn-warning" id="btn-send-assign-email" data-toggle="modal"
                                    data-target="#modal-assign-sample" disabled><i class="fa fa-paper-plane"
                                        aria-hidden="true"></i> Assign To
                                    Email</button>
                            </div>
                            <div class="m-1">
                                <b>Sample ID: {{ $sampleID }}</b>, Please assign the sample request product bellow:
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-{{ $javascriptID }}" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Label</th>
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

    <!-- modal add user assign start-->
    <div class="modal fade" id="modal-{{ $javascriptID }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Assign Sample Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-{{ $javascriptID }}">
                        @csrf
                        <div class="form-group row">
                            <label for="user">User</label>
                            <select name="user" id="user" class="form-control"></select>
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-success">Assign</button>
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
    <!-- modal add user assign end-->
    <!-- modal add user assign start-->
    <div class="modal fade" id="modal-edit-{{ $javascriptID }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Edit Assign Sample Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-edit-{{ $javascriptID }}">
                        @csrf
                        <div class="form-group row">
                            <label for="user">User</label>
                            <select name="user" id="user-edit" class="form-control"></select>
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-success">Assign</button>
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
    <!-- modal add user assign end-->
    <!-- modal info assign start-->
    <div class="modal fade" id="modal-info-{{ $javascriptID }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Info Assign Sample Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="user">User</label>
                        <input type="text" disabled id="user-info" class="form-control">
                    </div>
                    <div class="form-group row">
                        <label for="user">Email</label>
                        <input type="text" disabled id="email-info" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal info assign end-->

    <!-- modal asign sample start-->
    <div class="modal fade" id="modal-assign-sample">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Assign Sample</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-asign-sample">
                        @csrf
                        <div class="form-group row">
                            <label for="name">PIC Note</label>
                            <input type="text" name="pic_note" id="pic-note" class="form-control"
                                placeholder="pic note">
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-primary">Assign</button>
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
    <script src="{{ asset('dist/js/sample-request/pic/sample-product-assign.min.js?q=') . time() }}"></script>
@endpush
