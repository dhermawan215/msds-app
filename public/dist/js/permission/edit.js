var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");

    var handlePermissionData = function () {
        $("#group-value").change(function (e) {
            e.preventDefault();
            const groupValueId = $(this).val();
            const moduleValueId = $("#module-value-custom").val();

            $.ajax({
                type: "POST",
                url: url + "/permission-management/permission",
                data: {
                    _token: csrf_token,
                    mValue: moduleValueId,
                    gValue: groupValueId,
                },
                dataType: "json",
                success: function (response) {
                    let responseData = response.data;

                    $("#is-akses").append(
                        $("<option>", {
                            value: responseData.id,
                            text: responseData.text,
                            attr: "selected",
                        })
                    );

                    $("#form-value").val(responseData.formValue);
                    $(".fungsi-permission").val(responseData.fungsi);
                    $(".fungsi-permission").tagsinput();
                    $("#btn-update").removeAttr("disabled");
                    handleIsAccess();
                },
                error: function (response) {
                    Swal.fire({
                        title: "Data not found",
                        text: "Return to Permission Management Dashboard",
                        icon: "question",
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                },
            });
        });
    };

    var handleIsAccess = function () {
        var dataPermissionSa = [
            {
                id: "1",
                text: "Yes",
            },
            {
                id: "0",
                text: "No",
            },
        ];

        $("#is-akses").select2({
            data: dataPermissionSa,
        });
    };

    var handleUpdateSa = function () {
        $("#form-edit-permission").submit(function (e) {
            e.preventDefault();

            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/permission/update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href =
                                url + "/permission-management";
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
            handleUpdateSa();
            handlePermissionData();
            // handleIsAccess();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
