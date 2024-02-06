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
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                @foreach ($userGroup as $ug)
                                    @if ($ug->name == 'SUPER_ADMIN')
                                        @php
                                            $idHref = '#custom-tabs-two-super-admin';
                                            $idTab = 'super-admin-tab';
                                            $groupValue = $ug->id;
                                        @endphp
                                    @elseif($ug->name == 'LAB_USER')
                                        @php
                                            $idHref = '#custom-tabs-two-lab-user';
                                            $idTab = 'lab-user-tab';
                                            $groupValue = $ug->id;
                                        @endphp
                                    @else
                                        @php
                                            $idHref = '#custom-tabs-two-reguler';
                                            $idTab = 'reguler-user-tab';
                                            $groupValue = $ug->id;
                                        @endphp
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link group-tab-custom" id="{{ $idTab }}"
                                            data-group="{{ $groupValue }}" data-toggle="pill" href="{{ $idHref }}"
                                            role="tab" aria-controls="custom-tabs-two-home"
                                            aria-selected="true">{{ $ug->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-two-super-admin" role="tabpanel"
                                    aria-labelledby="custom-tabs-two-home-tab">
                                    <form action="javascript:;" method="post" id="form-permission-superadmin">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="moduleValue" value="{{ base64_encode($menu->id) }}">
                                            <input type="hidden" name="groupValue" class="group-value-custom">
                                            <label for="">Access Permission</label>
                                            <select name="is_akses" id="is-akses-sa" class="form-control">
                                                <option>-Select Access Permission-</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="">Function</label>
                                            <input type="text" name="fungsi" id="fungsi-sa" class="form-control">
                                        </div>
                                        <div class="form-group row">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-lab-user" role="tabpanel"
                                    aria-labelledby="custom-tabs-two-profile-tab">
                                    <form action="javascript:;" method="post" id="form-permission-lab">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="moduleValue" value="{{ base64_encode($menu->id) }}">
                                            <input type="hidden" name="groupValue" class="group-value-custom">
                                            <label for="">Access Permission</label>
                                            <select name="is_akses" id="is-akses-lab" class="form-control">
                                                <option>-Select Access Permission-</option>
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
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-reguler" role="tabpanel"
                                    aria-labelledby="custom-tabs-two-messages-tab">
                                    <form action="javascript:;" method="post" id="form-permission-reguler">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="moduleValue"
                                                value="{{ base64_encode($menu->id) }}">
                                            <input type="hidden" name="groupValue" class="group-value-custom">
                                            <label for="">Access Permission</label>
                                            <select name="is_akses" id="is-akses-reg" class="form-control">
                                                <option>-Select Access Permission-</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="">Function</label>
                                            <input type="text" name="fungsi" id="fungsi-reg" class="form-control">
                                        </div>
                                        <div class="form-group row">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
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
