@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Setting</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Setting</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                            <p class="text-muted text-center">{{ Auth::user()->email }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">

                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link logs-link" href="#timeline"
                                        data-toggle="tab">Logs</a>

                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile</a>
                                </li>
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Change
                                        Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <form id="formChangePwd" action="javascript:;" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="old_password" class="form-control"
                                                        id="oldPassword" placeholder="old password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="new_password" class="form-control"
                                                        id="newPassword" placeholder="new password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Password
                                                    Confirmation</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="confirm_password" class="form-control"
                                                        id="confirmPassword" placeholder="confirmation new password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <span class="text-danger">Password rule: must be min length 8
                                                    character(Upercase,
                                                    Lowercase, numeric,
                                                    character)</span>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" id="btnUpdatePwd" class="btn btn-danger">Change
                                                        Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse" id="timelineUserLog">
                                        <div class="spinner-border" role="status" id="loaderUserLog">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <!-- timeline item -->

                                        <!-- END timeline item -->
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal" method="POST" id="formUpdateUserData">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="updateUser" id="updateUserData">
                                                        Update Data
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="inputName"
                                                    placeholder="Name" value="{{ Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Active Status</label>
                                            <div class="col-sm-10">
                                                <select name="is_active" id="isActive" class="form-control">
                                                    @php
                                                        $isActive = Auth::user()->is_active;
                                                    @endphp
                                                    @if ($isActive == '1')
                                                        @php
                                                            $msgActive = 'Active';
                                                        @endphp
                                                    @else
                                                        @php
                                                            $msgActive = 'Not Active';
                                                        @endphp
                                                    @endif
                                                    <option selected value="{{ $isActive }}">{{ $msgActive }}
                                                    </option>
                                                    <option>-Select-</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Not Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" id="btnUserUpdate"
                                                    class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <!-- /.content -->
@endsection
@section('custom_js')
    <script src="{{ asset('dist/js/user/user-setting.min.js?q=') . time() }}"></script>
@endsection
