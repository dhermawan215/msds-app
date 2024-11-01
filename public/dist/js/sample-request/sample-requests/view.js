var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const nameOfModule = "sample-request";

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
                url: url + "/sample-request/list",
                type: "POST",
                data: function (d) {
                    d._token = csrf_token;
                    d.sample_status = $("#status-sample").val();
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "id", orderable: false },
                { data: "subject", orderable: false },
                { data: "request", orderable: false },
                { data: "delivery", orderable: false },
                { data: "method", orderable: false },
                { data: "pic", orderable: false },
                { data: "creator", orderable: false },
                { data: "cs", orderable: false },
                { data: "status", orderable: false },
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
        //when click edit
        $("#tbl-" + nameOfModule + " tbody").on("click", "tr", function () {
            handleEdit(table.row(this).data());
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
        $("#status-sample").change(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        //initialize function when data table loaded
        //and if button change status clicked get val and parsing it
        $(document).on("click", ".btn-ch-pickup", function () {
            const srval = $(this).data("vx");
            handleChangeStatusPickup(srval);
        });
        $(document).on("click", ".btn-ch-accepted", function () {
            const vxval = $(this).data("vx");
            handleSubmitFormReview(vxval);
        });
        //initialize function after render datatable
        handleCancelSample();
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
    var handleEdit = function (param) {
        $(document).on("click", ".btn-edit", function () {
            //   insert data to field in modal
            var dataEdit = $(this).data("edit");

            $("#source-name-edit").val(param.name);
            $("#address-edit").val(param.address);

            handleUpdate(dataEdit);
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
                        url: url + "/sample-request/delete",
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
                                table.ajax.reload();
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
    //change status pickup to accepted by customer
    var handleChangeStatusPickup = function (srval) {
        $("#checkbox-pickup-accepted").on("change", function () {
            if ($(this).is(":checked")) {
                const cbxval = $(this).data("cbx");
                $.ajax({
                    type: "POST",
                    url: url + "/sample-request/change-status",
                    data: {
                        _token: csrf_token,
                        vx: srval,
                        cbx: cbxval,
                    },
                    dataType: "json",
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
                        }, 3500);
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
    //submit change status reviewed
    var handleSubmitFormReview = function (vxval) {
        $("#form-reviewd-sales").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("vx", vxval);
            $.ajax({
                url: `${url}/sample-request/change-status`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.href = responses.url;
                    }, 3500);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    //cancle the sample request
    var handleCancelSample = function () {
        $(document).on("click", ".btn-change-to-cancel", function () {
            const vxValue = $(this).data("vx");
            const sample = $(this).data("sample");
            Swal.fire({
                title: "Are you sure cancel the sample?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url + "/sample-request/cancel-sample",
                        data: {
                            _token: csrf_token,
                            vx: vxValue,
                            status: 6,
                            sValue: sample,
                        },
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire(
                                    "Cancel success",
                                    "The sample request has been canceled",
                                    "success"
                                );
                                table.ajax.reload();
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

    return {
        init: function () {
            handleDataTable();
            handleDelete();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
