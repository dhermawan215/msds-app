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
                        <li class="breadcrumb-item ">Module Management</li>
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
                            <h3 class="card-titile">Edit Module: {{ $moduleData->name }} </h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" class="form-horizontal" method="POST" id="formEditModule">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="form_value" id="form-value"
                                    value="{{ base64_encode($moduleData->id) }}">
                                <div class="form-group row">
                                    <label for="name">Module Name</label>
                                    <input type="text" name="name" id="moduleName" class="form-control"
                                        placeholder="module name" value="{{ $moduleData->name }}">
                                </div>

                                <div class="form-group row">
                                    <label for="email">Route Name</label>
                                    <input type="text" name="route_name" id="routeName" class="form-control"
                                        placeholder="route name" value="{{ $moduleData->route_name }}">
                                </div>
                                <div class="form-group row">
                                    <label for="link">Link</label>
                                    <input type="text" name="link_path" id="link" class="form-control"
                                        placeholder="link/url" value="{{ $moduleData->link_path }}">
                                </div>
                                <div class="form-group row">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        placeholder="description" value="{{ $moduleData->description }}">
                                </div>
                                <div class="form-group row">
                                    <label for="icon">Icon</label>
                                    <input type="text" name="icon" id="icon" class="form-control"
                                        placeholder="icon" value="{{ $moduleData->icon }}">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" id="btnModuleUpdate"
                                            class="btn btn-success mr-1">Update</button>
                                        <a href="{{ route('admin_module.view') }}"
                                            class="btn btn-outline-secondary">Back</a>
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
    <script src="{{ asset('dist/js/module-mg/edit.min.js?q=') . time() }}"></script>
@endpush
