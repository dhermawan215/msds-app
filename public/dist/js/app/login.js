var Index = (function () {
    var handleLogin = function () {
        $("#loginForm").submit(function (e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(form[0]);

            $.ajax({
                url: url + "/login",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success("authenticated!");
                    setTimeout(() => {
                        window.location = responses.data;
                    }, 2500);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    return {
        init: function () {
            handleLogin();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
