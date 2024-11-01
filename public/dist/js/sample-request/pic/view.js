var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const nameOfModule = "sample-pic";

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
                url: url + "/pic/sample-request/list",
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
        //when click edit
        $("#tbl-" + nameOfModule + " tbody").on("click", "tr", function () {
            handleAssign(table.row(this).data());
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
    };

    //handle edit data
    var handleAssign = function (param) {
        $(document).on("click", ".btn-assign", function () {
            //   insert data to field in modal
            $("#sample-id").val(param.id);
            var as = $(this).data("as");
            handleAssignForm(as);
        });
    };
    //handle form assign
    var handleAssignForm = function (as) {
        $("#form-asign-sample").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("as", as);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/pic/sample-request/send-assign`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            $("#modal-assign-sample").modal("toggle");
                            $("#form-assign-sample").trigger("reset");
                            $("#assign-to").val(null).empty().trigger("change");
                            table.ajax.reload();
                        }, 2500);
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

    //get list of user dropdown
    var handleAssignUser = function () {
        $("#assign-to").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select user/type user for assign sample",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/pic/sample-request/assign",

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
            templateResult: format,
            templateSelection: formatSelection,
        });
    };

    //select 2 main function
    function format(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }

    // button click open transaction
    var handleOpenTransaction = function () {
        $(document).on("click", ".btn-open-tr", function (e) {
            e.preventDefault();
            const transactionValue = $(this).data("tr");
            if (confirm("Are you sure open this sample?")) {
                $.ajax({
                    url: `${url}/pic/sample-request/open-transaction`,
                    type: "POST",
                    data: {
                        _token: csrf_token,
                        tr: transactionValue,
                    },
                    // contentType: "json",
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            table.ajax.reload();
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
    // button click delivery information
    var handleDeliveryInformation = function () {
        $(document).on("click", ".btn-delivery", function (e) {
            e.preventDefault();
            const deliveryValue = $(this).data("dl");

            $.ajax({
                url: `${url}/pic/sample-request/delivery-information`,
                type: "POST",
                data: {
                    _token: csrf_token,
                    dl: deliveryValue,
                },
                // contentType: "json",
                success: function (responses) {
                    var dataResponse = responses.data;
                    $("#delivery-name").val(dataResponse.delivery_name);
                    $("#receipt").val(dataResponse.receipt);
                },
                error: function (response) {},
            });
        });
    };

    return {
        init: function () {
            handleDataTable();
            handleAssignUser();
            handleOpenTransaction();
            handleDeliveryInformation();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
