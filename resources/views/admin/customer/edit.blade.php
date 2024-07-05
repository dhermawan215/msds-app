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
                        <li class="breadcrumb-item">Customer</li>
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
                            <h3 class="card-titile">Edit Customer: {{ $value->customer_name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-edit-customer">
                                @csrf
                                <input type="hidden" name="formValue" value="{{ base64_encode($value->id) }}">
                                <div class="form-group row">
                                    <label for="name">User</label>
                                    <select name="sales" id="user" class="form-control">
                                        <option selected value="{{ $value->customerUser ? $value->customerUser->id : 0 }}">
                                            {{ $value->customerUser ? $value->customerUser->name : 'empty' }}</option>
                                        @foreach ($user as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="name">Customer Code</label>
                                    <input type="text" name="customer_code" id="customer-code-edit" class="form-control"
                                        placeholder="customer code" value="{{ $value->customer_code }}">
                                </div>
                                <div class="form-group row">
                                    <label for="name">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer-name-edit" class="form-control"
                                        placeholder="customer name"value="{{ $value->customer_name }}">
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                                    <a href="{{ route('admin_customer') }}" class="btn btn-outline-danger">Discard</a>
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
    <script src="{{ asset('dist/js/admin/customer/edit.min.js?q=') . time() }}"></script>
@endpush
