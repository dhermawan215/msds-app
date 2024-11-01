@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ Str::title(str_replace('-', ' ', $nameOfModule)) }}</li>
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
                            <h3 class="card-titile">{{ Str::title(str_replace('-', ' ', $nameOfModule)) }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                        <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                    </button>
                                    <button type="button" id="btn-add" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#modal-add-{{ $nameOfModule }}">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" id="btn-delete" disabled><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                </div>
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-{{ $nameOfModule }}" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px;">#</th>
                                            <th style="width: 30px;">No</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th style="width: 220px;">Action</th>
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

    <!-- modal add unit start-->
    <div class="modal fade" id="modal-add-{{ $nameOfModule }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Add {{ Str::title(str_replace('-', ' ', $nameOfModule)) }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-add-{{ $nameOfModule }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name">Source Name</label>
                            <input type="text" name="source_name" id="source-name" class="form-control"
                                placeholder="ex: KBI/Jababeka">
                        </div>
                        <div class="form-group row">
                            <label for="name">Address</label>
                            <input type="text" name="address" id="address" class="form-control"
                                placeholder="address sample soucr">
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
    <!-- modal add unit end-->
    <!-- modal edit unit start-->
    <div class="modal fade" id="modal-edit-{{ $nameOfModule }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Edit {{ Str::title(str_replace('-', ' ', $nameOfModule)) }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-edit-{{ $nameOfModule }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name">Source Name</label>
                            <input type="text" name="source_name" id="source-name-edit" class="form-control"
                                placeholder="source name">
                        </div>
                        <div class="form-group row">
                            <label for="name">Address</label>
                            <input type="text" name="address" id="address-edit" class="form-control"
                                placeholder="address">
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
    <!-- modal edit unit end-->
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
        ModuleFn = @json($moduleFn)
    </script>
    <script src="{{ asset('dist/js/rnd/sample-source/view.min.js?q=') . time() }}"></script>
@endpush
