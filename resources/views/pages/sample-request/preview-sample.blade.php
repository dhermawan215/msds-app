@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">

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
                            <h3 class="card-titile">Preview of Sample Request</h3>
                        </div>
                        <div class="card-body">
                            <div class="m-1">
                                <div class="mb-2">
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>
                                        Back</a>
                                </div>
                            </div>
                            <div class="m-1">

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
                                            placeholder="subject of sample" value="{{ $sample->subject }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="request-date">Request date</label>
                                        <input type="date" name="request_date" id="request-date" class="form-control"
                                            value="{{ $sample->request_date }}" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="delivery-date">Delivery date</label>
                                        <input type="date" name="delivery_date" id="delivery-date" class="form-control"
                                            value="{{ $sample->delivery_date }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="language">Sample Souce</label>
                                        <select name="sample_source" id="sample-source" class="form-control" disabled>
                                            <option selected value="{{ $sample->sample_source_id }}">
                                                {{ $sample->sampleSource->name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="delivery-by">Delivery By</label>
                                        <select name="delivery_by" id="delivery-by" class="form-control" disabled>
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

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Requestor note</label>
                                        <input type="text" name="requestor_note" id="requestor-note" class="form-control"
                                            placeholder="requestor note" value="{{ $sample->requestor_note }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Customer</label>
                                        <input type="text" class="form-control"
                                            value="{{ $sampleCustomer->sampleCustomer->customer_name }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Customer PIC</label>
                                        <input type="text" class="form-control"
                                            value="{{ $sampleCustomer->customer_pic }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Delivery Address</label>
                                        <input type="text" class="form-control"
                                            value="{{ $sampleCustomer->delivery_address }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Customer Note</label>
                                        <input type="text" class="form-control"
                                            value="{{ $sampleCustomer->customer_note }}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="m-1">
                                <label>Table product request</label>
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Label</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($sampleProducts as $value)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $value->sampleProduct
                                                    ? $value->sampleProduct->product_code . '-' . $value->sampleProduct->product_function
                                                    : 'Not found ' }}
                                                </td>
                                                <td>{{ $value->qty }}</td>
                                                <td>{{ $value->label_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
