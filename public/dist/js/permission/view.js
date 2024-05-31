var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var handleDataTabelUser = function () {
        table = $("#tblPermission").DataTable({
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
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 - 0 dari 0 data",
                infoFiltered: "",
                zeroRecords: "Data tidak di temukan",
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
                url: url + "/permission-management",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "name", orderable: false },
                { data: "path", orderable: false },
                { data: "action", orderable: false },
            ],
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
    };

    return {
        init: function () {
            handleDataTabelUser();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
