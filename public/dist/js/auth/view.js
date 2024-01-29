var Index = (function () {
    var handleLogout = function () {
        $("#formLogout").submit(function (e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(form[0]);

            if (confirm("Are you sure to logout?")) {
                $.ajax({
                    url: url + "/logout",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success("success!");
                        setTimeout(() => {
                            window.location = responses.data;
                        }, 2500);
                    },
                    error: function (response) {},
                });
            }
        });
    };
    return {
        init: function () {
            handleLogout();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
