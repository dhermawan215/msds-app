var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");

    var handleSubmit = function () {
        $("#form-add-prevention").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is it correct?")) {
                $.ajax({
                    url: url + "/prevention-precautionary/save",
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
            handleSubmit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
