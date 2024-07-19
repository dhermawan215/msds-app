var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];
    const nameOfModule = "sample-product";

    var handleDataTable = function () {
        table = $("#tbl-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: true,
            // pageLength: 15,
            dom: "Bfrtip",
            buttons: ["pageLength", "csv", "excel", "pdf"],
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
                url: url + "/sample-request/product-detail/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                    sampleID: sampleID,
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "product", orderable: false },
                { data: "qty", orderable: false },
                { data: "label", orderable: false },
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
                const recordsOfProduct = settings.json.recordOfDataProduct;
                if (recordsOfProduct === 0) {
                    $("#btn-send").attr("disabled", "disabled");
                } else {
                    $("#btn-send").removeAttr("disabled");
                }
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
            $.ajax({
                type: "post",
                url: `${url}/sample-request/product-detail/edit`,
                data: {
                    _token: csrf_token,
                    sampleProduct: dataEdit,
                },
                dataType: "json",
                success: function (response) {
                    var responseData = response.data;
                    var sampleProduct = responseData.sample_product;
                    $("#qty-edit").val(responseData.qty);
                    $("#label-name-edit").val(responseData.label_name);
                    $("#product-edit").append(
                        $("<option>", {
                            value: responseData.product_id,
                            text:
                                sampleProduct.product_code +
                                "-" +
                                sampleProduct.product_function,
                            attr: "selected",
                        })
                    );
                    handleproductDropdownEdit();
                },
            });

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
                        url: url + "/sample-request/product-detail/delete",
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

    // add data
    var handleAdd = function () {
        $("#form-add-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/sample-request/product-detail/save`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            table.ajax.reload();
                            $("#form-add-" + nameOfModule).trigger("reset");
                            $("#product").val(null).empty().trigger("change");
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
    // add data
    var handleUpdate = function (dataEdit) {
        $("#form-edit-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("formValue", dataEdit);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/sample-request/product-detail/update`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.reload();
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
    // get customer dropdown
    var handleproductDropdownEdit = function () {
        $("#product-edit").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select product/type product code or product function",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/sample-request/product-detail",

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
    // get customer dropdown
    var handleproductDropdown = function () {
        $("#product").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select product/type product code or product function",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/sample-request/product-detail",

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

    //send request of sample
    var handleSendRequest = function () {
        $("#btn-send").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: url + "/sample-request/send-request",
                data: {
                    _token: csrf_token,
                    sampleID: sampleID,
                },
                dataType: "json",
                beforeSend: function () {
                    $(".loading-spinner").show();
                },
                success: function (response) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.href = response.url;
                    }, 2500);
                },
                complete: function () {
                    $(".loading-spinner").hide();
                },
                error: function (response) {},
            });
        });
    };

    return {
        init: function () {
            handleAdd();
            handleproductDropdown();
            handleDataTable();
            handleDelete();
            handleSendRequest();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
