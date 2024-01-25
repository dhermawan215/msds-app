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
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active">Change Password</li>
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
                            <h3 class="card-titile">Change Password User: {{ $user->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="formChangePassword">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="form_value" id="form-value"
                                    value="{{ base64_encode($user->id) }}">
                                <div class="form-group row">
                                    <label for="password">New Password</label>
                                    <input type="password" name="new_password" id="newPassword" class="form-control"
                                        placeholder="Password rules: must be min length 8 character(Upercase,Lowercase, numeric,character)">
                                </div>
                                <div class="form-group row">
                                    <label for="password">Password Confirmation</label>
                                    <input type="password" name="password_confirmation" id="passwordConfirm"
                                        class="form-control"
                                        placeholder="Password rules: must be min length 8 character(Upercase,Lowercase, numeric,character)">
                                </div>
                                <div class="form-group row mt-1">
                                    <button type="submit" class="btn btn-success mr-1">Change Password</button>
                                    <a href="{{ route('admin.user_mg') }}" class="btn btn-outline-secondary">Back</a>
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
    <script src="{{ asset('dist/js/users-mg/change-pwd.min.js?q=') . time() }}"></script>
@endpush
