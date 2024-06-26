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
                        <li class="breadcrumb-item active">Add Permission</li>
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
                            <h5>Menu Name: {{ $menu->description }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-permission-lab">
                                @csrf
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
                                    <input type="hidden" name="moduleValue" value="{{ base64_encode($menu->id) }}">

                                    <label for="">Access Permission</label>
                                    <select name="is_akses" id="is-akses-lab" class="form-control">
                                        <option value="">-Select Access Permission-</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="">Function</label>
                                    <input type="text" name="fungsi" id="fungsi-lab" class="form-control">
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('admin_permission') }}"
                                        class="ml-1 btn btn-outline-secondary">Back</a>
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
    <!-- /.content -->
@endsection
@push('custom_js')
    <script src="{{ asset('frontend/plugins/input_tags/tagsinput.min.js') }}"></script>
    <script src="{{ asset('dist/js/permission/add.min.js?q=') . time() }}"></script>
@endpush
