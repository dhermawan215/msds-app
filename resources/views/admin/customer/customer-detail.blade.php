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
                        <li class="breadcrumb-item active">Sales - Customer</li>
                        <li class="breadcrumb-item active">Customer Detail</li>
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
                            <h3 class="card-titile">Customer Detail Dashboard</h3>
                            <hr>
                            <h6>Customer name: {{ $customer->customer_name }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <a href="{{ route('admin_customer') }}" class="btn btn-sm btn-outline-secondary"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>
                                        Back</a>
                                    <button type="button" class="btn btn-sm btn-success" id="btnRefresh">
                                        <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                    </button>
                                    <button type="button" id="btn-add" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#modal-add-customer-detail">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" id="btn-delete" disabled><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                </div>
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-customer-detail" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px;">#</th>
                                            <th style="width: 30px;">No</th>
                                            <th>PIC Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
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

    <!-- modal add customer start-->
    <div class="modal fade" id="modal-add-customer-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Customer Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-add-customer-detail">
                        @csrf
                        <div class="form-group row">
                            <label for="name">Customer PIC</label>
                            <input type="text" name="customer_pic" id="customer-pic" class="form-control"
                                placeholder="customer pic">
                        </div>
                        <div class="form-group row">
                            <label for="name">Customer Phone</label>
                            <input type="text" name="customer_phone" id="customer-phone" class="form-control"
                                placeholder="customer phone">
                        </div>
                        <div class="form-group row">
                            <label for="name">Customer Address</label>
                            <textarea name="customer_address" id="customer-address" cols="30" rows="5" class="form-control"></textarea>
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
    <!-- modal add customer end-->
    <!-- modal edit customer start-->
    <div class="modal fade" id="modal-edit-customer-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Customer Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-edit-customer-detail">
                        @csrf
                        <div class="form-group row">
                            <label for="name">Customer PIC</label>
                            <input type="text" name="customer_pic" id="customer-pic-edit" class="form-control"
                                placeholder="customer pic">
                        </div>
                        <div class="form-group row">
                            <label for="name">Customer Phone</label>
                            <input type="text" name="customer_phone" id="customer-phone-edit" class="form-control"
                                placeholder="customer phone">
                        </div>
                        <div class="form-group row">
                            <label for="name">Customer Address</label>
                            <textarea name="customer_address" id="customer-address-edit" cols="30" rows="5" class="form-control"></textarea>
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
    <!-- modal edit customer end-->
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
        ModuleFn = @json($moduleFn);
        var customerName = '{{ base64_encode($customer->id) }}';
    </script>
    <script src="{{ asset('dist/js/admin/customer/view-detail.min.js?q=') . time() }}"></script>
@endpush
