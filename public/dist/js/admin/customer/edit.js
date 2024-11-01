var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    const moduleName = "customer";

    //update data
    var handleUpdate = function () {
        $("#form-edit-" + moduleName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/admin/customer/update`,
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
    // get user data for select 2
    var handleUserCustomer = function () {
        $("#user").select2({});
    };

    return {
        init: function () {
            handleUpdate();
            handleUserCustomer();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
