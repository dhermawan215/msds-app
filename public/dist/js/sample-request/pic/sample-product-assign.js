var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    const nameOfModule = "assign-sample-product";

    var handleDataTable = function () {
        table = $("#tbl-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: true,
            // pageLength: 15,
            dom: "Bfrtip",
            buttons: ["pageLength"],
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
                url: url + "/pic/sample-request/sample-product-information",
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
            drawCallback: function (settings) {
                const recordUnsignSampleProduct = settings.json.sampleUnSign;
                if (
                    recordUnsignSampleProduct !== 0 ||
                    recordUnsignSampleProduct === "false"
                ) {
                    $("#btn-send-assign-email").attr("disabled", "disabled");
                } else {
                    $("#btn-send-assign-email").removeAttr("disabled");
                    handleSendAssignToEmail(sampleID);
                }
            },
        });
        // btn refresh on click
        $("#btnRefresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        getAssignValue();
        getAssignInformation();
        getEditAssign();
    };

    // get user assign dropdown
    var handleproductDropdown = function () {
        $("#user").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select user for assign this sample product",
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
    // get customer dropdown
    var handleEditUserAssign = function () {
        $("#user-edit").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select user for assign this sample product",
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

    //get assign value from button
    var getAssignValue = function () {
        $(document).on("click", ".btn-assign", function () {
            const assignValue = $(this).data("assg");
            handleSendAssignForm(assignValue);
        });
    };
    //get assign value from button
    var getAssignInformation = function () {
        $(document).on("click", ".btn-info-assign", function () {
            const assignValue = $(this).data("assg");
            $.ajax({
                url: `${url}/pic/sample-request/info-assign-sample-product`,
                type: "POST",
                data: {
                    _token: csrf_token,
                    av: assignValue,
                },
                // contentType: "json",
                success: function (responses) {
                    var dataResponse = responses.data;
                    $("#user-info").val(dataResponse.user);
                    $("#email-info").val(dataResponse.email);
                },
                error: function (response) {
                    toastr.error("something went wrong, please try again");
                },
            });
        });
    };
    //get edit assign value from button
    var getEditAssign = function () {
        $(document).on("click", ".btn-edit-assign", function () {
            const assignValue = $(this).data("assg");
            $.ajax({
                url: `${url}/pic/sample-request/edit-assign-sample-product`,
                type: "POST",
                data: {
                    _token: csrf_token,
                    av: assignValue,
                },
                // contentType: "json",
                success: function (responses) {
                    var dataResponse = responses.data;
                    var selectId = dataResponse.id;
                    var selectText = dataResponse.text;

                    // Cek apakah opsi sudah ada di dalam select
                    var found = false;
                    $("#user-edit option").each(function () {
                        if ($(this).val() == selectId) {
                            $(this).prop("selected", true); // Pilih opsi ini jika ditemukan
                            found = true;
                            return false; // Keluar dari loop jika ditemukan
                        }
                    });

                    // Jika tidak ditemukan, tambahkan opsi baru dan pilih
                    if (!found) {
                        var newOption = new Option(
                            selectText,
                            selectId,
                            true,
                            true
                        );
                        $("#user-edit").append(newOption).trigger("change");
                    }
                    handleEditUserAssign();
                    handleUpdateAssignForm(assignValue);
                },
                error: function (response) {
                    toastr.error("something went wrong, please try again");
                },
            });
        });
    };
    //send assign form sample request product
    var handleSendAssignForm = function (assignValue) {
        $("#form-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("as", assignValue);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/pic/sample-request/send-assign-sample-product`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            $("#modal-" + nameOfModule).modal("toggle");
                            $("#form-" + nameOfModule).trigger("reset");
                            $("#user").val(null).empty().trigger("change");
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
    //send assign form sample request product
    var handleUpdateAssignForm = function (assignValue) {
        $("#form-edit-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("as", assignValue);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/pic/sample-request/assign-sample-product/update`,
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

    var handleSendAssignToEmail = function (as) {
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
                            window.location.href = responses.url;
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

    return {
        init: function () {
            handleproductDropdown();
            handleDataTable();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
