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
                        <li class="breadcrumb-item">Storage Precautionary Statement</li>
                        <li class="breadcrumb-item active">Edit Data</li>
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
                            <h3 class="card-titile">Edit Storage Precautionary Statement</h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-edit-storage-precautionary">
                                @csrf
                                <input type="hidden" name="formValue" id="form-value"
                                    value="{{ base64_encode($value->id) }}">
                                <div class="form-group row">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        placeholder="Code of response precautionary" value="{{ $value->code }}">
                                </div>
                                <div class="form-group row">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        placeholder="Description of response precautionary"
                                        value="{{ $value->description }}">
                                </div>
                                <div class="form-group row">
                                    <label for="language">Language</label>
                                    @if ($value->language == 'ID')
                                        @php
                                            $lang = 'Indonesia';
                                            $langValue = 'ID';
                                        @endphp
                                    @else
                                        @php
                                            $lang = 'English';
                                            $langValue = 'EN';
                                        @endphp
                                    @endif
                                    <select name="language" id="language" class="form-control">
                                        <option value="{{ $langValue }}">{{ $lang }}</option>
                                        <option>-Select language-</option>
                                        <option value="ID">Indonesia</option>
                                        <option value="EN">English</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
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
    <script src="{{ asset('dist/js/msds/storage-precautionary/edit.min.js?q=') . time() }}"></script>
@endpush
