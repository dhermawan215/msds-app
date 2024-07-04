var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const moduleName = "company";

    var handleDataTable = function () {
        table = $("#tbl-" + moduleName).DataTable({
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
                url: url + "/admin/company/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "logo", orderable: false },
                { data: "name", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                $(".data-menu-cbox").on("click", function () {
                    handleAddDeleteAselected(
                        $(this).val(),
                        $(this).parents()[1]
                    );
                });
                $("#btn-delete").attr("disabled", "");
                aSelected.splice(0, aSelected.length);
            },
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        if ($.inArray("add", ModuleFn) !== -1) {
            $("#btn-add").removeClass("disabled");
        } else {
            $("#btn-add").addClass("disabled");
        }
    };
    //push data to variable aSelected
    var handleAddDeleteAselected = function (value, parentElement) {
        var check_value = $.inArray(value, aSelected);
        if (check_value !== -1) {
            $(parentElement).removeClass("table-dark");
            aSelected.splice(check_value, 1);
        } else {
            $(parentElement).addClass("table-dark");
            aSelected.push(value);
        }

        handleBtnDisableEnable();
    };
    //control button disabled enable
    var handleBtnDisableEnable = function () {
        if (aSelected.length > 0) {
            $("#btn-delete").removeAttr("disabled");
        } else {
            $("#btn-delete").attr("disabled", "");
        }
    };
    //handle edit data
    var handleEdit = function () {
        $(document).on("click", ".btn-edit", function () {
            //   insert data to field in modal
            var dataEdit = $(this).data("edit");

            $.ajax({
                type: "POST",
                url: url + "/admin/company/show",
                data: {
                    _token: csrf_token,
                    sVal: dataEdit,
                },
                dataType: "json",
                success: function (response) {
                    let responseData = response.data;
                    $("#company-name-edit").val(responseData.name);
                    $("#phone-edit").val(responseData.phone);
                    $("#address-edit").val(responseData.address);
                },
            });

            handleUpdate(dataEdit);
        });
    };
    //handle change logo
    var handleChangeLogo = function () {
        $(document).on("click", ".btn-change-logo", function () {
            //   insert data to field in modal
            var dataChangeLogo = $(this).data("change");

            handleUpdateLogo(dataChangeLogo);
        });
    };
    //handle show detail
    var handleDetail = function (param) {
        $(document).on("click", ".btn-detail", function () {
            //   insert data to field in modal
            var dataDetail = $(this).data("detail");
            $.ajax({
                type: "POST",
                url: url + "/admin/company/show",
                data: {
                    _token: csrf_token,
                    sVal: dataDetail,
                },
                dataType: "json",
                success: function (response) {
                    let responseData = response.data;
                    $("#company-name-detail").val(responseData.name);
                    $("#phone-detail").val(responseData.phone);
                    $("#address-detail").val(responseData.address);
                },
            });
        });
    };
    //delete method
    var handleDelete = function () {
        $("#btn-delete").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url + "/admin/company/delete",
                        data: {
                            _token: csrf_token,
                            dValue: aSelected,
                        },
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                );
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2500);
                            }
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Internal Server Error",
                            });
                        },
                    });
                }
            });
        });
    };
    // add data
    var handleAdd = function () {
        $("#form-add-" + moduleName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("is right?")) {
                $.ajax({
                    url: `${url}/admin/company/save`,
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
            }
        });
    };
    //update data
    var handleUpdate = function (idEdit) {
        $("#form-edit-" + moduleName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("formValue", idEdit);
            if (confirm("is right?")) {
                $.ajax({
                    url: `${url}/admin/company/update`,
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
            }
        });
    };
    //update logo
    var handleUpdateLogo = function (idChangeLogo) {
        $("#form-change-logo-" + moduleName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("formValue", idChangeLogo);
            if (confirm("is right?")) {
                $.ajax({
                    url: `${url}/admin/company/update-logo`,
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
            }
        });
    };

    return {
        init: function () {
            handleDataTable();
            handleDelete();
            handleAdd();
            handleDetail();
            handleEdit();
            handleChangeLogo();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
