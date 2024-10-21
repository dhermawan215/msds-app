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
                        <li class="breadcrumb-item active">CS Sample Request Dashboard</li>
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
                            <h3 class="card-titile">CS Sample Request Dashboard</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                        <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" id="btn-reload">
                                        <i class="fa fa-undo" aria-hidden="true"></i> Reload page
                                    </button>
                                </div>
                            </div>
                            <div class="m-1">
                                <div class="form-row">
                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                        <label for=""><i class="fa fa-filter" aria-hidden="true"></i> Status
                                            Sample</label>
                                        <select name="status_sample" id="status-sample" class="form-control">
                                            <option value="3" selected>Pick up</option>
                                            <option value="7">All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="m-1">
                                <hr>
                                <table class="table table-bordered" id="tbl-sample-cs" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Request</th>
                                            <th>Delivery</th>
                                            <th>Delivery By</th>
                                            <th style="width: 10px;">Sample PIC</th>
                                            <th style="width: 10px;">Sample Creator</th>
                                            <th style="width: 10px;">CS</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <hr>
                        <div class="row m-2">
                            <div class="col-lg-3">Approval status:</div>
                            <div class="col-lg-2">Pending: <i class="fa fa-clock"></i></div>
                            <div class="col-lg-2">Process: <i class="fa fa-paper-plane"></i></div>
                            <div class="col-lg-2">Finish: <i class="fa fa-check"></i></div>
                            <div class="col-lg-2">Not Found: <i class="fa fa-minus"></i></div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>

            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>

    <!-- modal delivery information start-->
    <div class="modal fade" id="modal-info-delivery">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Delivery Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="">Delivery name</label>
                        <input type="text" id="delivery-name-info" readonly class="form-control">
                    </div>
                    <div class="form-group row">
                        <label for="name">Receipt</label>
                        <input type="text" id="receipt-info" readonly class="form-control">
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
    <!-- modal delivery information end-->
    <!-- modal add receipt information start-->
    <div class="modal fade" id="modal-add-receipt">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Add Receipt</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-add-receipt">
                        @csrf
                        <div class="form-group row">
                            <label for="">Delivery name</label>
                            <input type="text" id="delivery-name" name="delivery_name" class="form-control"
                                placeholder="e.g.: JNE, JNT, POS INDONESIA, DHL">
                        </div>
                        <div class="form-group row">
                            <label for="name">Receipt</label>
                            <input type="text" id="receipt" name="receipt" class="form-control"
                                placeholder="e.g.: RX2323H2323">
                        </div>
                        <div class="form-group row">
                            <label for="name">CS Note</label>
                            <input type="text" id="cs-note" name="cs_note" class="form-control"
                                placeholder="Notes">
                        </div>
                        <div class="form-group row">
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
    <!-- modal add receipt information end-->
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
    <script src="{{ asset('dist/js/sample-request/cs/view.min.js?q=') . time() }}"></script>
@endpush
