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
        $(".logs-link").on("click", function () {
            $.ajax({
                type: "POST",
                url: url + "/user-setting/user-log",
                data: {
                    _token: csrf_token,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#loaderUserLog").show();
                },
                success: function (response) {
                    const valueResponse = response.content;

                    $.each(valueResponse, function (indexInArray, activity) {
                        const activityItem = $("<div>", {
                            class: "activity-item",
                            html:
                                " <i class='fas fa-user bg-info'></i><div class='timeline-item'><span class='time'><i class='far fa-clock'></i> " +
                                activity.date_time +
                                "</span><h3 class='timeline-header border-0'><a>" +
                                activity.name +
                                "-(" +
                                activity.email +
                                ")</a>: " +
                                activity.activity +
                                "</h3></div>",
                        });
                        $("#timelineUserLog").append(activityItem);
                    });
                    // $("#timelineUserLog").html(response.content);
                },
                complete: function () {
                    // Hide image container
                    $("#loaderUserLog").hide();
                },
            });
        });
    };
    return {
        init: function () {
            handleUpdateUser();
            handleCbxUserUpdate();
            handleUpdatePwd();
            handleUserLogActivity();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
