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
                        <li class="breadcrumb-item active">Response Precautionary Statement</li>
                        <li class="breadcrumb-item active">Add Data</li>
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
                            <h3 class="card-titile">Add Response Precautionary Statement</h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-add-response">
                                @csrf
                                <div class="form-group row">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        placeholder="Code of response precautionary">
                                </div>
                                <div class="form-group row">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        placeholder="Description of response precautionary">
                                </div>
                                <div class="form-group row">
                                    <label for="language">Language</label>
                                    <select name="language" id="language" class="form-control">
                                        <option value="null">-Select language-</option>
                                        <option value="ID">Indonesia</option>
                                        <option value="EN">English</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    <a href="{{ $url }}" class="btn btn-outline-danger">Discard</a>
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
    <script src="{{ asset('dist/js/precautionary/response/add.min.js?q=') . time() }}"></script>
@endpush
