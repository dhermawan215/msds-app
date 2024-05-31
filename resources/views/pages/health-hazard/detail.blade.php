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
                        <li class="breadcrumb-item">Health Hazard</li>
                        <li class="breadcrumb-item active">Detail Data</li>
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
                            <h3 class="card-titile">Detail Health Hazard</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="code">Code</label>
                                <input type="text" readonly class="form-control" value="{{ $value->code }}">
                            </div>
                            <div class="form-group row">
                                <label for="description">Description</label>
                                <input type="text" readonly class="form-control" value="{{ $value->description }}">
                            </div>
                            <div class="form-group row">
                                <label for="language">Language</label>
                                @if ($value->language == 'ID')
                                    @php
                                        $lang = 'Indonesia';
                                    @endphp
                                @else
                                    @php
                                        $lang = 'English';
                                    @endphp
                                @endif
                                <input type="text" readonly class="form-control" value="{{ $lang }}">
                            </div>
                            <div class="form-group row">
                                <a href="{{ $url }}" class="btn btn-secondary">Back</a>
                            </div>

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
@endpush
