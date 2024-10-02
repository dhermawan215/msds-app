var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    const nameOfModule = "confirm-sample-product";

    var handleDataTable = function () {
        table = $("#tbl-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: true,
            // pageLength: 15,
            dom: "Bfrtip",
            buttons: ["pageLength"],
            searching: true,
            paging: true,
            lengthMenu: [
                [15, 25, 50],
                [15, 25, 50],
            ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            columnsDefs: [
                { searchable: false, target: [0, 1] },
                { orderable: false, target: 0 },
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/rnd/sample-request/confirm/product-list",
                type: "POST",
                data: {
                    _token: csrf_token,
                    sampleID: sampleID,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "product", orderable: false },
                { data: "qty", orderable: false },
                { data: "label", orderable: false },
                { data: "creator", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                const finishedProduct = settings.json.finished;
                const rndStatus = settings.json.rnd_status;
                handleEnableSubmit(finishedProduct, rndStatus);
            },
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        $("#btn-refresh-page").click(function (e) {
            e.preventDefault();
            window.location.reload();
        });
        handleFinished();
        handlePrintLabel();
        handleInformation();
        handleDeleteGhs();
        handleUploadFile();
    };

    var handleGhs = function () {
        $("#ghs").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select ghs/type ghs name",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/rnd/sample-request/confirm/ghs-list",

                data: function (params) {
                    return {
                        _token: csrf_token,
                        search: params.term,
                        page: params.page || 1, // search term
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: true,
                        },
                    };
                },
            },
            templateResult: formatOption,
            templateSelection: formatSelection,
            multiple: true,
        });

        // Event listener to update the preview area whenever the selection changes
        $("#ghs").on("change", function () {
            updatePreview();
        });
    };

    // Render dropdown options with image
    function formatOption(option) {
        if (!option.id) return option.text; // Return plain text if no id (e.g. placeholder)

        return $(
            '<span><img src="' +
                option.path +
                '" style="width: 30px; height: 30px; margin-right: 10px;" /> ' +
                option.text +
                "</span>"
        );
    }

    // Render the selected options with images and update preview area
    function formatSelection(option) {
        if (!option.id) return option.text;

        updatePreview();

        return option.text;
    }

    // Function to update image preview based on selected options
    function updatePreview() {
        var selectedOptions = $("#ghs").select2("data");
        $("#ghs-preview").empty(); // Clear previous previews

        // Loop through selected options and append each image
        selectedOptions.forEach(function (item) {
            $("#ghs-preview").append(
                '<img src="' + item.path + '" alt="' + item.text + '"/>'
            );
        });

        // If no options are selected, clear the preview
        if (selectedOptions.length === 0) {
            $("#ghs-preview").empty(); // No options, clear the preview
        }
    }
    // funcion to set readonly or not when dropdown changed.
    var handleBatchNumberLab = function () {
        $("#batch-type").change(function (e) {
            e.preventDefault();

            const batchTypeVal = $(this).val();
            if (batchTypeVal === "LAB") {
                $("#batch-number").attr("readonly", true);
                requestBatchNumber();
            } else {
                $("#batch-number").removeAttr("readonly");
                $("#batch-number").val("");
            }
        });
    };
    //when batch type is lab, ajax request data batch number to backend
    var requestBatchNumber = function () {
        $.ajax({
            type: "post",
            url: url + "/rnd/sample-request/batch-number",
            data: {
                _token: csrf_token,
            },
            dataType: "json",
            success: function (response) {
                $("#batch-number").val(response.data);
            },
            error: function (response) {
                toastr.error("error");
            },
        });
    };
    // when button add batch click, open modal and form ready to fill
    var handleOpenFormandSubmit = function () {
        $(document).on("click", ".btn-add-batch", function () {
            const sampleVal = $(this).data("sr");
            const productVal = $(this).data("pr");
            const sampleReProdVal = $(this).data("srp");
            console.log(sampleReProdVal, sampleVal, productVal);

            $("#form-add-sample-detail").submit(function (e) {
                e.preventDefault();
                const form = $(this);
                let formData = new FormData(form[0]);
                formData.append("srVal", sampleVal);
                formData.append("prVal", productVal);
                formData.append("srpVal", sampleReProdVal);
                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: `${url}/rnd/sample-request/confirm/create-sample-detail`,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (responses) {
                            toastr.success(responses.message);
                            location.reload();
                        },
                        error: function (response) {
                            $.each(
                                response.responseJSON,
                                function (key, value) {
                                    toastr.error(value);
                                }
                            );
                        },
                    });
                }
            });
        });
    };
    // method to confirm sample is finish
    var handleFinished = function () {
        $(document).on("click", ".btn-finished", function () {
            const sampleReProdid = $(this).data("srp");
            if (confirm("Are you sure finish the process?")) {
                $.ajax({
                    type: "POST",
                    url: url + "/rnd/sample-request/confirm/finished",
                    data: {
                        _token: csrf_token,
                        srp: sampleReProdid,
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    },
                    error: function (response) {
                        toastr.error(response.message);
                    },
                });
            }
        });
    };
    //action for print label
    var handlePrintLabel = function () {
        $(document).on("click", ".btn-print", function () {
            const vsrp = $(this).data("vsrp");
            const vpr = $(this).data("vpr");
            const vsr = $(this).data("vsr");

            $("#form-print-label").submit(function (e) {
                e.preventDefault();
                const copyLabel = $("#copy-of-label").val();
                const retain = $("#retain").val();
                document.location.href =
                    url +
                    "/rnd/sample-request/label-print?vsrp=" +
                    vsrp +
                    "&vpr=" +
                    vpr +
                    "&vsr=" +
                    vsr +
                    "&retain=" +
                    retain +
                    "&copy=" +
                    copyLabel;
            });
        });
    };
    //action get information for modal sample request product
    var handleInformation = function () {
        $(document).on("click", ".btn-inf", function () {
            const svsrp = $(this).data("srp");
            const svpr = $(this).data("pr");
            const svsr = $(this).data("sr");
            $.ajax({
                type: "POST",
                url: url + "/rnd/sample-request/confirm/information",
                data: {
                    _token: csrf_token,
                    nodeVsrp: svsrp,
                    nodeVpr: svpr,
                    nodeVsr: svsr,
                },
                dataType: "json",
                success: function (response) {
                    var responseData = response.data;
                    $("#process-finish").val(responseData.finished);
                    $("#name-assign-to").val(responseData.assign);
                    $("#batch-type-data").val(responseData.batch_type);
                    $("#batch-number-data").val(responseData.batch_number);
                    $("#product-remark").val(responseData.product_remarks);
                    $("#released-by-data").val(responseData.released_by);
                    $("#mfg-date").val(responseData.manufacture_date);
                    $("#expired-date").val(responseData.expired_date);
                },
                error: function (response) {},
            });
        });
    };
    //action delete data ghs (label)
    var handleDeleteGhs = function () {
        $(document).on("click", ".btn-delete-label", function () {
            const svsrp = $(this).data("srp");
            const svpr = $(this).data("pr");
            const svsr = $(this).data("sr");

            if (confirm("Are you sure delete this?!")) {
                $.ajax({
                    type: "POST",
                    url: url + "/rnd/sample-request/confirm/delete-ghs",
                    data: {
                        _token: csrf_token,
                        nVsrp: svsrp,
                        nVpr: svpr,
                        nVsr: svsr,
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success("delete success!");
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function (response) {
                        toastr.error("something went wrong, please try again");
                    },
                });
            }
        });
    };
    //check enable disable button for action submit sample request
    var handleEnableSubmit = function (finished, rnd_status) {
        if (finished === 0 && rnd_status === 1) {
            $("#btn-finish").removeAttr("disabled");
            handleFinishSampple();
        } else {
            $("#btn-finish").attr("disabled", true);
        }
    };
    // action to finished sample request
    var handleFinishSampple = function () {
        $("#form-submit-sample").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("sampleId", sampleID);
            $.ajax({
                url: `${url}/rnd/sample-request/confirm/submit-sample`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);

                    setTimeout(() => {
                        window.location.href = responses.url;
                    }, 2000);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    //handle submit form
    var handleUploadFile = function () {
        $(document).on("click", ".btn-upload-msdspds", function () {
            const dataSrp = $(this).data("srp");
            handleDataMsds(dataSrp);
            handleSubmitFormUpload(dataSrp);
        });
    };
    //data table msds / pds
    var handleDataMsds = function (dataSrp) {
        var tableMsds;
        // Check if the table is already initialized
        if ($.fn.DataTable.isDataTable("#tabel-msds-pds")) {
            // Destroy the existing DataTable instance
            $("#tabel-msds-pds").DataTable().clear().destroy();
        }

        tableMsds = $("#tabel-msds-pds").DataTable({
            responsive: true,
            autoWidth: true,
            pageLength: 15,
            // dom: "Bfrtip",
            // buttons: ["pageLength"],
            searching: true,
            paging: true,
            lengthMenu: [
                [15, 25, 50],
                [15, 25, 50],
            ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            columnsDefs: [
                { searchable: false, target: [0, 1] },
                { orderable: false, target: 0 },
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/rnd/sample-request/msds-pds-list",
                type: "POST",
                data: {
                    _token: csrf_token,
                    srp: dataSrp,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "category", orderable: false },
                { data: "name", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {},
        });
        $("#tabel-msds-pds").on("click", "tr", function () {
            var rowData = tableMsds.row(this).data();

            // Pastikan rowData tidak undefined atau null
            if (rowData && rowData.name && rowData.path) {
                showPdfContent(rowData);
            } else {
                // Tampilkan pesan error atau lakukan tindakan lain jika data tidak valid
            }
        });
        handleDeleteDoc();
    };
    //submit form upload msds
    var handleSubmitFormUpload = function (dataSrp) {
        $("#form-upload-msds").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("srp", dataSrp);
            if (confirm("are you sure")) {
                $.ajax({
                    url: `${url}/rnd/sample-request/confirm/upload-msds`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function (response) {
                        $.each(response.responseJSON, function (key, value) {
                            toastr.error(value);
                        });
                    },
                });
            }
        });
    };
    //function to preview pdf document
    var showPdfContent = function (dataRow) {
        const documentName = dataRow.name;
        const documentHref = dataRow.path;

        var pdfElement =
            "<iframe src=" +
            documentHref +
            ' type="application/pdf" width="100%" height="350px"></iframe>';

        $("#document-name").html(documentName);
        $("#document-download").attr("href", documentHref);
        $("#pdf-container").html(pdfElement);
    };
    //delete document
    var handleDeleteDoc = function () {
        $(document).on("click", ".btn-delete-doc", function () {
            const docValue = $(this).data("dc");

            if (confirm("Are you sure delete the document?!")) {
                $.ajax({
                    type: "POST",
                    url: url + "/rnd/sample-request/confirm/delete-msds",
                    data: {
                        _token: csrf_token,
                        docVl: docValue,
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success("delete success!");
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function (response) {
                        toastr.error("something went wrong, please try again");
                    },
                });
            }
        });
    };

    return {
        init: function () {
            handleDataTable();
            handleGhs();
            handleBatchNumberLab();
            handleOpenFormandSubmit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
