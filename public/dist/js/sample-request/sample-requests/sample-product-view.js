var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const nameOfModule = "sample-msds";

    var handleDataTable = function () {
        table = $("#tbl-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: true,
            // pageLength: 15,
            searching: false,
            paging: true,
            // lengthMenu: [
            //     [15, 25, 50],
            //     [15, 25, 50],
            // ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            // columnsDefs: [
            //     { searchable: false, target: [0, 1] },
            //     { orderable: false, target: 0 },
            // ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/sample-request/download-msds/list",
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
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {},
        });
        handleShow();
    };
    //handle show table msds/pds data
    var handleShow = function () {
        $(document).on("click", ".btn-info-msds-pds", function () {
            const valueInfo = $(this).data("info");
            handleDataDocuments(valueInfo);
        });
    };

    var handleDataDocuments = function (valueInfo) {
        // Check if the table is already initialized
        if ($.fn.DataTable.isDataTable("#tbl-doc-msds")) {
            // Destroy the existing DataTable instance
            $("#tbl-doc-msds").DataTable().clear().destroy();
        }
        table = $("#tbl-doc-msds").DataTable({
            responsive: true,
            autoWidth: true,
            // pageLength: 15,
            searching: false,
            paging: true,
            // lengthMenu: [
            //     [15, 25, 50],
            //     [15, 25, 50],
            // ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            // columnsDefs: [
            //     { searchable: false, target: [0, 1] },
            //     { orderable: false, target: 0 },
            // ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/sample-request/download-msds/list-doc",
                type: "POST",
                data: {
                    _token: csrf_token,
                    vx: valueInfo,
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
    };

    return {
        init: function () {
            handleDataTable();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
