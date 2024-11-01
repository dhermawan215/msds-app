@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">

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
                            <h3 class="card-titile">Change Status of Sample Request</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <a href="{{ route('pic_sample_request') }}" class="btn btn-sm btn-outline-secondary"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>
                                        Back</a>
                                </div>
                            </div>
                            <div class="m-1">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        Sample ID: {{ $data->sample_ID }}
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        Subject: {{ $data->subject }}
                                    </div><!-- /.col -->
                                </div><!-- /.row -->

                                <div class="row mb-2">
                                    @switch($data->delivery_by)
                                        @case(1)
                                            @php
                                                $delivery = 'Expedition';
                                            @endphp
                                        @break

                                        @case(2)
                                            @php
                                                $delivery = 'Pick up by sales';
                                            @endphp
                                        @break

                                        @default
                                            @php
                                                $delivery = 'Pick up by customer';
                                            @endphp
                                    @endswitch
                                    <div class="col-sm-6">
                                        Delivery By: {{ $delivery }}
                                    </div><!-- /.col -->
                                    @php
                                        switch ($data->sample_status) {
                                            case 0:
                                                $sampleStatus = 'Requested';
                                                break;
                                            case 1:
                                                $sampleStatus = 'Confirm';
                                                break;
                                            case 2:
                                                $sampleStatus = 'Ready';
                                                break;
                                            case 3:
                                                $sampleStatus = 'Pick up';
                                                break;
                                            case 4:
                                                $sampleStatus = 'Accepted by customer';
                                                break;
                                            case 5:
                                                $sampleStatus = 'Reviewed';
                                                break;
                                            case 6:
                                                $sampleStatus = 'Cancel';
                                                break;
                                            default:
                                                $sampleStatus = 'Pending';
                                                break;
                                        }

                                    @endphp
                                    <div class="col-sm-6">
                                        Sample Status: {{ $sampleStatus }}
                                    </div><!-- /.col -->
                                </div>
                            </div>
                            <div class="m-1">
                                <hr>
                                <h6>Form change status</h6>
                                <form action="javascript:;" id="form-change-status" method="POST">
                                    @csrf
                                    <input type="hidden" name="sample_ID" value="{{ $data->sample_ID }}">
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="">Change Status</label>
                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" name="sample_status"
                                                    value="3" id="pickup-cbx">
                                                <label class="form-check-label" for="pickup-cbx">Pickup</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="">Sample PIC note</label>
                                            <input type="text" name="sample_pic_note" id="sample-pic-note"
                                                class="form-control" placeholder="sample pic note">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <button class="btn btn-primary" id="btn-change-status-submit">Change
                                                status</button>
                                        </div>
                                    </div>

                                </form>
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
    <script src="{{ asset('dist/js/sample-request/pic/change-status.min.js?q=') . time() }}"></script>
@endpush
