var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");

    var handleUpdate = function () {
        $("#form-edit-user-group").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            const formValue = $("#form-value").val();
            if (confirm("is right?")) {
                $.ajax({
                    url: `${url}/admin/user-group/update/${formValue}`,
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

    return {
        init: function () {
            handleUpdate();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
