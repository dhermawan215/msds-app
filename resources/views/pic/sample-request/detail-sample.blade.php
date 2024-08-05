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
                            <h3 class="card-titile">Detail of Sample Request</h3>
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

                                <div class="form-group row">
                                    <div class="col">
                                        <label for=sample-id"">Sample ID</label>
                                        <input type="text" name="sample_id" class="form-control" id="sample-id"
                                            value="{{ $data['sampleRequestData']->sample_ID }}" readonly>
                                    </div>
                                    <div class="col">
                                        <label for=sample-id"">Requestor</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data['sampleRequestData']->sampleRequestor->name }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control"
                                            placeholder="subject of sample"
                                            value="{{ $data['sampleRequestData']->subject }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="required-date">Required date</label>
                                        <input type="date" name="required_date" id="required-date" class="form-control"
                                            value="{{ $data['sampleRequestData']->required_date }}" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="delivery-date">Delivery date</label>
                                        <input type="date" name="delivery_date" id="delivery-date" class="form-control"
                                            value="{{ $data['sampleRequestData']->delivery_date }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="language">Sample Souce</label>
                                        <select name="sample_source" id="sample-source" class="form-control" disabled>
                                            <option selected value="{{ $data['sampleRequestData']->sample_source_id }}">
                                                {{ $data['sampleRequestData']->sampleSource ? $data['sampleRequestData']->sampleSource->name : 'empty data' }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="delivery-by">Delivery By</label>
                                        <select name="delivery_by" id="delivery-by" class="form-control" disabled>
                                            @switch($data['sampleRequestData']->delivery_by)
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
                                            <option selected value="{{ $data['sampleRequestData']->delivery_by }}">
                                                {{ $delivery }}
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Requestor note</label>
                                        <input type="text" name="requestor_note" id="requestor-note" class="form-control"
                                            value="{{ $data['sampleRequestData']->requestor_note }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Sample PIC note</label>
                                        <input type="text" name="requestor_note" id="requestor-note" class="form-control"
                                            value="{{ $data['sampleRequestData']->sample_pic_note }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Sample creator note(lab/wh)</label>
                                        <input type="text" name="requestor_note" id="requestor-note" class="form-control"
                                            value="{{ $data['sampleRequestData']->rnd_note }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Customer</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data['sampleRequestCustomer'] ? $data['sampleRequestCustomer']->sampleCustomer->customer_name : 'empty data' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Customer PIC</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data['sampleRequestCustomer'] ? $data['sampleRequestCustomer']->customer_pic : 'empty data' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Delivery Address</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data['sampleRequestCustomer'] ? $data['sampleRequestCustomer']->delivery_address : 'empty data' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="requestor-note">Customer Note</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data['sampleRequestCustomer'] ? $data['sampleRequestCustomer']->customer_note : 'empty data' }}"
                                            readonly>
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
                                        @foreach ($data['sampleRequestProduct'] as $product)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $product->sampleProduct
                                                    ? $product->sampleProduct->product_code . '-' . $product->sampleProduct->product_function
                                                    : 'empty data ' }}
                                                </td>
                                                <td>{{ $product->qty }}</td>
                                                <td>{{ $product->label_name }}</td>
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
