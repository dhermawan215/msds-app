var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");

    var handleUpdate = function () {
        $("#formEditModule").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            const formValue = $("#form-value").val();
            if (confirm("is right?")) {
                $.ajax({
                    url: `${url}/module-management/edit/${formValue}`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.data);
                        setTimeout(() => {
                            window.location.href = responses.redirect;
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
