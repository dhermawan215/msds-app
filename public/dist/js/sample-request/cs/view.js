var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const nameOfModule = "sample-cs";

    var handleDataTable = function () {
        table = $("#tbl-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: true,
            // pageLength: 15,
            dom: "Bfrtip",
            buttons: ["pageLength", "csv", "excel", "pdf", "print"],
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
                url: url + "/cs/sample-request/list",
                type: "POST",
                data: function (d) {
                    d._token = csrf_token;
                    d.sample_status = $("#status-sample").val();
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "id", orderable: false },
                { data: "subject", orderable: false },
                { data: "request", orderable: false },
                { data: "delivery", orderable: false },
                { data: "delivery_by", orderable: false },
                { data: "pic", orderable: false },
                { data: "creator", orderable: false },
                { data: "cs", orderable: false },
                { data: "status", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {},
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        $("#btn-reload").click(function (e) {
            e.preventDefault();
            window.location.reload();
        });
        $("#status-sample").change(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        handleAddReceipt();
    };

    // button click delivery information
    var handleDeliveryInformation = function () {
        $(document).on("click", ".btn-info-delivery", function (e) {
            e.preventDefault();
            const deliveryValue = $(this).data("di");

            $.ajax({
                url: `${url}/cs/sample-request/delivery-information`,
                type: "POST",
                data: {
                    _token: csrf_token,
                    dl: deliveryValue,
                },
                // contentType: "json",
                success: function (responses) {
                    var responseData = responses.data;
                    $("#delivery-name-info").val(responseData.delivery_name);
                    $("#receipt-info").val(responseData.receipt);
                },
                error: function (response) {
                    toastr.error("error, please try again");
                },
            });
        });
    };
    // handle action add receipt button
    var handleAddReceipt = function () {
        $(document).on("click", ".btn-add-receipt", function (e) {
            e.preventDefault();
            const diValue = $(this).data("di");

            $("#form-add-receipt").submit(function (e) {
                e.preventDefault();
                const form = $(this);
                let formData = new FormData(form[0]);
                formData.append("di", diValue);
                $.ajax({
                    url: url + "/cs/sample-request/receipt",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    },
                    error: function (response) {
                        $.each(response.responseJSON, function (key, value) {
                            toastr.error(value);
                        });
                    },
                });
            });
        });
    };

    return {
        init: function () {
            handleDataTable();
            handleDeliveryInformation();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
