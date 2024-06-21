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
                        <li class="breadcrumb-item ">User Group</li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-titile">Edit User Group: {{ $value->name }} </h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" class="form-horizontal" method="POST" id="form-edit-user-group">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="form_value" id="form-value"
                                    value="{{ base64_encode($value->id) }}">
                                <div class="form-group row">
                                    <label for="name">User Group Name</label>
                                    <input type="text" name="name" id="moduleName" class="form-control"
                                        placeholder="module name" value="{{ $value->name }}">
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" id="btn-update" class="btn btn-success mr-1">Update</button>
                                        <a href="{{ $url }}" class="btn btn-outline-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
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
    <script src="{{ asset('dist/js/admin/user-group/edit.min.js?q=') . time() }}"></script>
@endpush
