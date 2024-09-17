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
            drawCallback: function (settings) {},
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        handleFinished();
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
