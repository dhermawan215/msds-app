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
                        <li class="breadcrumb-item">Sample Request</li>
                        <li class="breadcrumb-item active">Edit Sample Request</li>
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
                            <h3 class="card-titile">Create Sample Request</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <a href="{{ route('sample_request') }}" class="btn btn-sm btn-outline-secondary"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>
                                        Back</a>
                                </div>
                            </div>
                            <div class="m-1">
                                <form action="javascript:;" method="post" id="form-edit-sample">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for=sample-id"">Sample ID</label>
                                            <input type="text" name="sample_id" class="form-control" id="sample-id"
                                                value="{{ $sample->sample_ID }}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for=sample-id"">Requestor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $sample->sampleRequestor->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="subject">Subject</label>
                                            <input type="text" name="subject" id="subject" class="form-control"
                                                placeholder="subject of sample" value="{{ $sample->subject }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="required-date">Required date</label>
                                            <input type="date" name="required_date" id="required-date"
                                                class="form-control" value="{{ $sample->required_date }}">
                                        </div>
                                        <div class="col">
                                            <label for="delivery-date">Delivery date</label>
                                            <input type="date" name="delivery_date" id="delivery-date"
                                                class="form-control" value="{{ $sample->delivery_date }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="language">Sample Souce</label>
                                            <select name="sample_source" id="sample-source" class="form-control">
                                                <option selected value="{{ $sample->sample_source_id }}">
                                                    {{ $sample->sampleSource->name }}</option>
                                                <option value="0">-Select sample source-</option>
                                                @foreach ($sampleSource as $vSc)
                                                    <option value="{{ $vSc->id }}">{{ $vSc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="delivery-by">Delivery By</label>
                                            <select name="delivery_by" id="delivery-by" class="form-control">
                                                @switch($sample->delivery_by)
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
                                                            $delivery = 'Pick up';
                                                        @endphp
                                                @endswitch
                                                <option selected value="{{ $sample->delivery_by }}">{{ $delivery }}
                                                </option>
                                                <option value="0">Pick up</option>
                                                <option value="1">Expedition</option>
                                                <option value="2">Pick up by sales</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="requestor-note">Requestor note</label>
                                            <input type="text" name="requestor_note" id="requestor-note"
                                                class="form-control" placeholder="requestor note"
                                                value="{{ $sample->requestor_note }}">
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-center">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button type="reset" class="btn btn-outline-danger mr-2">Discard</button>
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
    <script src="{{ asset('dist/js/sample-request/sample-requests/edit-sample.min.js?q=') . time() }}"></script>
@endpush