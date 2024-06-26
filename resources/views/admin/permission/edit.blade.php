@extends('layouts.app')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('frontend/plugins/input_tags/tagsinput.min.css') }}">
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
                        <li class="breadcrumb-item active">Permission Management</li>
                        <li class="breadcrumb-item active">Edit Permission</li>
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
                            <h5>Edit Permission | Menu Name: {{ $menu->description }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-edit-permission">
                                @csrf
                                <input type="hidden" name="moduleValue" id="module-value-custom"
                                    class="module-value-custom" value="{{ base64_encode($menu->id) }}">
                                <input type="hidden" name="formValue" id="form-value">
                                <div class="form-group row">
                                    <label for="group-value">User Group</label>
                                    <select name="groupValue" id="group-value" class="form-control">
                                        <option value="">-Select user group-</option>
                                        @foreach ($userGroup as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="">Access Permission</label>
                                    <select name="is_akses" id="is-akses" class="form-control" style="width: 100%;">

                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="">Function</label>
                                    <input type="text" name="fungsi" id="fungsi-permission"
                                        class="form-control fungsi-permission">
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary" id="btn-update" disabled>Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin_permission') }}" class="btn btn-outline-danger mr-1">Discard</a>
                            <a href="{{ route('admin_permission') }}" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('custom_js')
    <script src="{{ asset('frontend/plugins/input_tags/tagsinput.min.js') }}"></script>
    <script src="{{ asset('dist/js/permission/edit.min.js?q=') . time() }}"></script>
@endpush
