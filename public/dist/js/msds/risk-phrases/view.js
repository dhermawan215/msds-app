var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const pageName = "risk-phrases";
    var handleDataTabelUser = function () {
        table = $("#tbl-" + pageName).DataTable({
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
                url: url + "/risk-phrases/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "code", orderable: false },
                { data: "desc", orderable: false },
                { data: "lang", orderable: false },
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
        //call the function when datatable finish the process
        handleEdit();
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
                        url: url + "/risk-phrases/delete",
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
    //metod submit form/save
    var handleSubmit = function () {
        $("#form-add-" + pageName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is it correct?")) {
                $.ajax({
                    url: url + "/risk-phrases/save",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.reload();
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
    //method detail when cliick button
    var handleEdit = function () {
        $(document).on("click", ".btn-edit", function (e) {
            e.preventDefault();
            const dlVal = $(this).data("ed");

            $.ajax({
                url: `${url}/risk-phrases/edit`,
                type: "POST",
                data: {
                    _token: csrf_token,
                    de: dlVal,
                },
                // contentType: "json",
                success: function (responses) {
                    var dataResponse = responses.data;
                    $("#description-edit").val(dataResponse.description);
                    $("#code-edit").val(dataResponse.code);
                    // Cek apakah nilai option sudah ada dalam select
                    var found = false;
                    $("#language-edit option").each(function () {
                        if ($(this).val() == dataResponse.lang_value) {
                            $(this).prop("selected", true); // Pilih opsi ini jika ditemukan
                            found = true;
                            return false; // Keluar dari loop jika ditemukan
                        }
                    });

                    // Jika tidak ditemukan, tambahkan opsi baru dan pilih
                    if (!found) {
                        $("#language-edit").append(
                            $("<option>", {
                                value: dataResponse.lang_value,
                                text: dataResponse.lang,
                                selected: true,
                            })
                        );
                    }

                    handleUpdate(dlVal);
                },
                error: function (response) {},
            });
        });
    };

    //metod update
    var handleUpdate = function (dlVal) {
        $("#form-edit-" + pageName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("du", dlVal);

            if (confirm("is it correct?")) {
                $.ajax({
                    url: url + "/risk-phrases/update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.reload();
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

    return {
        init: function () {
            handleDataTabelUser();
            handleDelete();
            handleSubmit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
