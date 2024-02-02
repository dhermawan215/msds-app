var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var handleDataTabelUser = function () {
        table = $("#tblAdminUserMg").DataTable({
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
                url: url + "/users-management",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "name", orderable: false },
                { data: "email", orderable: false },
                { data: "roles", orderable: false },
                { data: "status", orderable: false },
                { data: "action", orderable: false },
            ],
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        if ($.inArray("add", ModuleFn) !== -1) {
            $("#btnRegUser").removeAttr("disabled");
        } else {
            $("#btnRegUser").attr("disabled", "disabled");
        }
    };

    var handleRegistration = function () {
        $("#formUserRegister").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/users-management/user-registration",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success("success!");
                        setTimeout(() => {
                            $("#modal-userReg").modal("toggle");
                            table.ajax.reload();
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

    var handleUserActive = function () {
        $(document).on("change", ".activeuser", function () {
            if ($(this).is(":checked")) {
                const cbxVal = $(this).data("toggle");
                const activeVal = "1";

                $.ajax({
                    type: "POST",
                    url: `${url}/users-management/user-active`,
                    data: {
                        _token: csrf_token,
                        cbxValue: cbxVal,
                        acValue: activeVal,
                    },
                    success: function (response) {
                        toastr.success(response.data);
                    },
                });
            } else {
                const cbxVal = $(this).data("toggle");
                const activeVal = "0";
                $.ajax({
                    type: "POST",
                    url: `${url}/users-management/user-active`,
                    data: {
                        _token: csrf_token,
                        cbxValue: cbxVal,
                        acValue: activeVal,
                    },
                    success: function (response) {
                        toastr.success(response.data);
                    },
                });
            }
        });
    };
    return {
        init: function () {
            handleDataTabelUser();
            handleRegistration();
            handleUserActive();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
