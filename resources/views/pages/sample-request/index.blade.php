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
                        <li class="breadcrumb-item active">Sample Request Dashboard</li>
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
                            <h3 class="card-titile">Your Sample Request Dashboard</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                        <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                    </button>
                                    <a href="{{ route('sample_request.add') }}" id="btn-add"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Create Sample
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" id="btn-delete" disabled><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                </div>
                            </div>
                            <div class="mt-1 mb-3">
                                <div class="form-row">
                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                        <label for=""><i class="fa fa-filter" aria-hidden="true"></i> Filter Status
                                            Sample</label>
                                        <select name="status_sample" id="status-sample" class="form-control">
                                            <option value="0">Requested</option>
                                            <option value="1">Confirm</option>
                                            <option value="2">Ready</option>
                                            <option value="3">Pick up</option>
                                            <option value="4">Accepted by customer</option>
                                            <option value="5">Reviewed</option>
                                            <option value="6">Cancel</option>
                                            <option selected value="7">All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-sample-request" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 15px;">#</th>
                                            <th style="width: 10px;">No</th>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Request</th>
                                            <th>Delivery</th>
                                            <th>Method</th>
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
    <!-- modal change status to accepted by customer start-->
    <div class="modal fade" id="modal-pickup-accepted" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal change status to accepted by customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group form-check">
                        <input class="form-check-input" type="checkbox" value="true" data-cbx='4'
                            id="checkbox-pickup-accepted">
                        <label class="form-check-label" for="checkbox-pickup-accepted">
                            Accepted by customer
                        </label>
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
    <!-- modal change status to accepted by customer  end-->
    <!-- modal change status to reviewed start-->
    <div class="modal fade" id="modal-accepted-review" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal change status to reviewed</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-reviewd-sales">
                        @csrf
                        <div class="form-group form-check">
                            <input class="form-check-input" name="cbx" type="checkbox" value="5"
                                data-cbx='5' id="checkbox-reviewed" required>
                            <label class="form-check-label" for="exampleCheck1">Reviewed</label>
                        </div>
                        <div class="form-group">
                            <label for="">Customer note</label>
                            <input type="text" name="customer_note" id="customer-note" class="form-control"
                                placeholder="customer note">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
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
    <!-- modal change status to reviewed  end-->
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
    <script src="{{ asset('dist/js/sample-request/sample-requests/view.min.js?q=') . time() }}"></script>
@endpush
