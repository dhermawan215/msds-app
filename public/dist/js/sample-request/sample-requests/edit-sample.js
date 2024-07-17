var Index = (function () {
    const moduleName = "sample";

    // add data
    var handleUpdate = function () {
        $("#form-edit-" + moduleName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/sample-request/edit-sample/update`,
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
            }
        });
    };

    return {
        init: function () {
            handleUpdate();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
