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
                        <li class="breadcrumb-item active">Edit User Data</li>
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
                            <h3 class="card-titile">Edit User Data: {{ $user->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="formEditUser">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="form_value" id="form-value"
                                    value="{{ base64_encode($user->id) }}">
                                <div class="form-group row">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group row">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group row">
                                    <label for="roles">Active</label>
                                    <select name="is_active" id="active" class="form-control">
                                        @if ($user->is_active == '1')
                                            @php
                                                $msg = 'Active';
                                            @endphp
                                        @else
                                            @php
                                                $msg = 'Non Active';
                                            @endphp
                                        @endif
                                        <option selected value="{{ $user->is_active }}">{{ $msg }}</option>
                                        <option>-Select Data-</option>
                                        <option value="1">Active</option>
                                        <option value="0">Non active</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="roles">Roles</label>
                                    <select name="roles" id="roles" class="form-control">

                                        <option selected value="{{ $user->userGroup->id }}">{{ $user->userGroup->name }}
                                        </option>
                                        <option>-Select Data-</option>
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group row mt-1">
                                    <button type="submit" class="btn btn-success mr-1">Update</button>
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
    <script src="{{ asset('dist/js/users-mg/edit.min.js?q=') . time() }}"></script>
@endpush
