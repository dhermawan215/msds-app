var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var handleCbxUserUpdate = function () {
        $("#inputName").attr("disabled", "disabled");
        $("#isActive").attr("disabled", "disabled");
        $("#btnUserUpdate").attr("disabled", "disabled");

        $("#updateUserData").on("click", function () {
            if ($("#updateUserData").is(":checked")) {
                $("#inputName").removeAttr("disabled");
                $("#isActive").removeAttr("disabled");
                $("#btnUserUpdate").removeAttr("disabled");
            } else {
                $("#inputName").attr("disabled", "disabled");
                $("#isActive").attr("disabled", "disabled");
                $("#btnUserUpdate").attr("disabled", "disabled");
            }
        });
    };

    var handleUpdateUser = function () {
        $("#formUpdateUserData").submit(function (e) {
            e.preventDefault();

            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/user-setting/update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success("success!");
                        setTimeout(() => {
                            location.reload();
                        }, 4500);
                    },
                    error: function (response) {},
                });
            }
        });
    };

    var handleUpdatePwd = function () {
        $("#formChangePwd").submit(function (e) {
            e.preventDefault();

            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("are you sure change password?")) {
                $.ajax({
                    url: url + "/user-setting/password-update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.data);
                        setTimeout(() => {
                            location.reload();
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

    var handleUserLogActivity = function () {
        $.ajax({
            type: "POST",
            url: url + "/user-setting/user-log",
            data: {
                _token: csrf_token,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            },
        });
    };
    return {
        init: function () {
            handleUpdateUser();
            handleCbxUserUpdate();
            handleUpdatePwd();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
