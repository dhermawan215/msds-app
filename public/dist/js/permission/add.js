var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;

    var handleInputTag = function () {
        $("#fungsi-sa").tagsinput();
        $("#fungsi-lab").tagsinput();
        $("#fungsi-reg").tagsinput();
    };

    var handleTabClick = function () {
        $(".group-tab-custom").on("click", function () {
            const groupValue = $(this).data("group");
            $(".group-value-custom").val(groupValue);
        });
    };

    var handleSubmitSa = function () {
        $("#form-permission-superadmin").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/save",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
                            window.location.href = responses.url;
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
    var handleSubmitLab = function () {
        $("#form-permission-lab").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/save",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
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
    var handleSubmitReguler = function () {
        $("#form-permission-reguler").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/save",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success("success!");
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
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
            handleInputTag();
            handleSubmitSa();
            handleSubmitLab();
            handleSubmitReguler();
            handleTabClick();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
