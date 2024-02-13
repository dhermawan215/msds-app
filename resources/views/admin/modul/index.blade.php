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
                    <li class="breadcrumb-item active">Module Management</li>
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
                        <h3 class="card-titile">Module Management</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Refresh Data
                            </button>
                            <button type="button" id="btnAddModule" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-addModule">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Module
                            </button>
                        </div>
                        <table class="table table-bordered" id="tblModule" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Route</th>
                                    <th>Path</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>

<!-- modal register user -->
<div class="modal fade" id="modal-addModule">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Add Module</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" method="post" id="formAddModule">
                    @csrf
                    <div class="form-group row">
                        <label for="name">Module Name</label>
                        <input type="text" name="name" id="moduleName" class="form-control" placeholder="module name">
                    </div>
                    <div class="form-group row">
                        <label for="email">Route Name</label>
                        <input type="text" name="route_name" id="routeName" class="form-control" placeholder="route name">
                    </div>
                    <div class="form-group row">
                        <label for="link">Link</label>
                        <input type="text" name="link_path" id="link" class="form-control" placeholder="link/url">
                    </div>
                    <div class="form-group row">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="description">
                    </div>
                    <div class="form-group row">
                        <label for="icon">Icon</label>
                        <input type="text" name="icon" id="icon" class="form-control" placeholder="icon">
                    </div>
                    <div class="form-group row">
                        <label for="order_menu">Order Menu Position</label>
                        <input type="text" name="order_menu" id="order_menu" class="form-control" placeholder="order menu">
                    </div>

                    <div class="form-group row mt-1">
                        <button type="submit" class="btn btn-primary">Add Module</button>
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
<!-- /.content -->
@endsection
@push('custom_js')
<script>
    ModuleFn = @json($moduleFn)
</script>
<script src="{{ asset('dist/js/module-mg/view.min.js?q=') . time() }}"></script>
@endpush