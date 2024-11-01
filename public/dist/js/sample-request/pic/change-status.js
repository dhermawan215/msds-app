var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    // function handle submit form change status (pic sample)
    var submitChangeStatus = function () {
        $("#form-change-status").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/pic/sample-request/changed-status`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
                        }, 2500);
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
            submitChangeStatus();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
