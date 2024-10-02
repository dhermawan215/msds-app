@extends('layouts.app')
@section('custom_css')
    <style>
        .select2 {
            width: 100% !important;
        }

        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        .img-preview {
            display: flex;
            flex-wrap: wrap;
        }

        .img-preview img {
            margin: 5px;
            width: 75px;
            height: 75px;
        }
    </style>
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
                        <li class="breadcrumb-item">Sample Request</li>
                        <li class="breadcrumb-item active">Confirm Sample Request Product</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-titile">Confirm Sample Request Product Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="ml-1">
                                <a href="{{ $homeUrl }}" class="btn btn-sm btn-outline-danger"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnRefresh">
                                    <i class="fa fa-retweet" aria-hidden="true"></i> Refresh
                                </button>
                                <button type="button" class="btn btn-sm btn-success" id="btn-refresh-page">
                                    <i class="fa fa-retweet" aria-hidden="true"></i> Reload Page
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" id="btn-finish" data-toggle="modal"
                                    data-target="#modal-submit" disabled>
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i> Finish & Submit
                                </button>

                            </div>
                            <div class="m-1">
                                <b>Sample ID: {{ $sampleID }}</b>, Please confirm and fill the batch/ghs the sample
                                request product bellow:
                            </div>
                            <div class="m-1">
                                <table class="table table-bordered" id="tbl-{{ $javascriptID }}" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Label</th>
                                            <th>Pic/Creator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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

    <!-- modal asign sample start-->
    <div class="modal fade" id="modal-add-sample-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Add Sample Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-add-sample-detail">
                        @csrf
                        <div class="form-group row">
                            <label for="name">Batch Type</label>
                            <select name="batch_type" id="batch-type" class="form-control">
                                <option selected value="">-Select Batch Type-</option>
                                <option value="PROD">PRODUCTION</option>
                                <option value="LAB">LAB</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="batch-number">Batch Number</label>
                            <input type="text" name="batch_number" id="batch-number" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="product-remarks">Product Remarks</label>
                            <input type="text" name="product_remarks" id="product-remarks" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="released-by">Released By</label>
                            <select name="released_by" id="released-by" class="form-control">
                                <option value="">-Select Released-</option>
                                <option value="Research & Development">Research & Development</option>
                                <option value="Warehouse">Warehouse</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="netto">Netto</label>
                            <input type="text" name="netto" id="netto" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="batch-number">Manufacture Date</label>
                            <input type="date" name="manufacture_date" id="manufacture-date" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="expired-date">Expired Date</label>
                            <input type="date" name="expired_date" id="expired_date" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="ghs">GHS Label</label>
                            <select name="ghs[]" id="ghs" class="form-control"></select>
                        </div>
                        <div class="form-group row">
                            <div class="img-preview" id="ghs-preview"></div>
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal asign sample end-->
    <!-- modal asign sample start-->
    <div class="modal fade" id="modal-print-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Print Label</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-print-label">
                        <div class="form-group row">
                            <label for="batch-number">Copy of label</label>
                            <input type="number" max="4" name="copy_of_label" id="copy-of-label"
                                class="form-control">
                            <p class="text-small">max copy row is 4, 1 row contains 2 labels </p>
                        </div>
                        <div class="form-group row">
                            <label for="retain">Retain</label>
                            <select name="retain" id="retain" class="form-control">
                                <option value="true">Retain</option>
                                <option value="false">No</option>
                            </select>
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-primary">Print</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal asign sample end-->
    <!-- modal sample detail information start -->
    <div class="modal fade" id="modal-info-sample-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col">
                            <label for="process-finish">Process Finish</label>
                            <input type="text" id="process-finish" readonly class="form-control">
                        </div>
                        <div class="col">
                            <label for="name-assign-to">Assign to</label>
                            <input type="text" id="name-assign-to" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="batch-type-data">Batch Type</label>
                            <input type="text" id="batch-type-data" readonly class="form-control">
                        </div>
                        <div class="col">
                            <label for="batch-number-data">Batch Number</label>
                            <input type="text" id="batch-number-data" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="product-remark">Product Remark</label>
                            <input type="text" id="product-remark" readonly class="form-control">
                        </div>
                        <div class="col">
                            <label for="released-by">Released By</label>
                            <input type="text" id="released-by-data" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="mfg-date">Manufacture Date</label>
                            <input type="text" id="mfg-date" readonly class="form-control">
                        </div>
                        <div class="col">
                            <label for="expired-date">Expired Date</label>
                            <input type="text" id="expired-date" readonly class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal sample detail information end -->
    <!-- modal submit sample request start -->
    <div class="modal fade" id="modal-submit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal submit sample</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="form-submit-sample">
                        @csrf
                        <div class="form-group row">
                            <label for="rnd-note">R&D Note</label>
                            <input type="text" name="rnd_note" id="rnd-note" class="form-control">
                        </div>
                        <div class="form-group row mt-1">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal submit sample request end -->
    <!-- modal upload msds pds start -->
    <div class="modal fade" id="modal-upload-msdspds">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal upload msds pds</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row p-2">
                        <form action="javascript:;" method="post" id="form-upload-msds" enctype="multipart/form-data">
                            @csrf
                            <p class="text-danger">file must be in pdf format & max size: 2MB</p>
                            <div class="form-group row">
                                <div class="col">
                                    <label for="document-category">Document Category</label>
                                    <select name="document_category" id="document-category" class="form-control">
                                        <option value="">-select category-</option>
                                        <option value="MSDS">MSDS</option>
                                        <option value="PDS">PDS</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="file-upload">File</label>
                                    <input type="file" name="file_upload" id="file_upload" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Table MSDS/PDS was uploaded.</p>
                            <table class="table" id="tabel-msds-pds" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>File name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal upload msds pds end -->
    <!-- modal preview document start -->
    <div class="modal fade" id="modal-preview-docoment">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal preview document: <span id="document-name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="pdf-container">

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <p>Unable to display a PDF file? <a href="" id="document-download">Download</a> Instead.</p>
                    <button type="button" class="btn btn-default" id="force-close" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- modal preview document end -->
@endsection
@push('custom_js')
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        var sampleID = '{{ $sampleID }}';
    </script>
    <script src="{{ asset('dist/js/rnd/sample-request/sample-product-confirm.min.js?q=') . time() }}"></script>
@endpush
