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
                    <li class="breadcrumb-item active">Physical Hazard</li>
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
                        <h3 class="card-titile">Physical Hazard</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Refresh Data
                            </button>
                            <a href="{{ route('physical_hazard.add') }}" id="add-data" class="btn btn-primary btn-sm disabled"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add Data</a>
                        </div>
                        <table class="table table-bordered" id="tblPhysicalHazard" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Code</th>
                                    <th>Desc</th>
                                    <th style="width: 30px">Lang</th>
                                    <th style="width: 220px;">Action</th>
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
@endsection
@push('custom_js')
<script>
    ModuleFn = @json($moduleFn)
</script>
<script src="{{ asset('dist/js/physical-hazard/view.min.js?q=') . time() }}"></script>
@endpush