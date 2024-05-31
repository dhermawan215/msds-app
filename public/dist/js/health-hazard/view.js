var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var handleDataTabelUser = function () {
        table = $("#tbl-health-hazard").DataTable({
            responsive: true,
            autoWidth: true,
            pageLength: 15,
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
                url: url + "/health-hazard/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "code", orderable: false },
                { data: "desc", orderable: false },
                { data: "lang", orderable: false },
                { data: "action", orderable: false },
            ],
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        if ($.inArray("add", ModuleFn) !== -1) {
            $("#add-data").removeClass("disabled");
        } else {
            $("#add-data").addClass("disabled");
        }
    };

    var handleDelete = function () {
        $(document).on("click", ".btn-delete-data", function () {
            const dataButton = $(this).data("button");
            if (confirm("Are you sure delete this data?")) {
                $.ajax({
                    url: url + "/health-hazard/delete/" + dataButton,
                    type: "DELETE",
                    data: {
                        _token: csrf_token,
                    },
                    // processData: false,
                    // contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 4500);
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

    return {
        init: function () {
            handleDataTabelUser();
            handleDelete();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
