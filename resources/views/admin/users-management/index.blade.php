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
                    <li class="breadcrumb-item active">User Management</li>
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
                        <h3 class="card-titile">User Management</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Refresh Data
                            </button>
                            <button type="button" id="btnRegUser" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-userReg">
                                <i class="fa fa-plus" aria-hidden="true"></i> Register User
                            </button>
                        </div>
                        <table class="table table-bordered" id="tblAdminUserMg">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th style="width: 40px">Active</th>
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
<div class="modal fade" id="modal-userReg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal User Registration</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" method="post" id="formUserRegister">
                    @csrf
                    <div class="form-group row">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name">
                    </div>
                    <div class="form-group row">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="email">
                    </div>
                    <div class="form-group row">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="password">
                        <span class="text-danger">Password rules: must be min length 8
                            character(Upercase,
                            Lowercase, numeric,
                            character)</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="roles">Roles</label>
                            <select name="roles" id="roles" class="form-control">
                                <option selected>-Select Data-</option>
                                <option value="2">Lab_User</option>
                                <option value="3">Reguler_User</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="roles">Active</label>
                            <select name="is_active" id="active" class="form-control">
                                <option selected>-Select Data-</option>
                                <option value="1">Active</option>
                                <option value="0">Non active</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-1">
                        <button type="submit" class="btn btn-primary">Register</button>
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
<script src="{{ asset('dist/js/users-mg/view.min.js?q=') . time() }}"></script>
@endpush