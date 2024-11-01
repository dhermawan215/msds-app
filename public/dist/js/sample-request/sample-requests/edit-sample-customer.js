var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    const moduleName = "customer-edit";

    //get information customer data
    var getInfoCustomer = function () {
        $.ajax({
            type: "post",
            url: `${url}/sample-request/edit-customer/info`,
            data: {
                _token: csrf_token,
                vsampleID: sampleID,
            },
            dataType: "json",
            success: function (response) {
                var responseData = response.data;
                //parsing value to dropdown customer
                $("#customer").append(
                    $("<option>", {
                        value: responseData.c,
                        text: responseData.customer_name,
                        attr: "selected",
                    })
                );
                //parsing value to dropdown customer pic
                $("#customer-pic").append(
                    $("<option>", {
                        value: responseData.customer_pic,
                        text: responseData.customer_pic,
                        attr: "selected",
                    })
                );
                //parsing value to dropdown customer address
                $("#customer-address").append(
                    $("<option>", {
                        value: responseData.delivery_address,
                        text: responseData.delivery_address,
                        attr: "selected",
                    })
                );
                $("#sval").val(responseData.iV);
            },
        });
    };
    // add data
    var handleAdd = function () {
        $("#form-" + moduleName).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `${url}/sample-request/edit-customer/update`,
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
    // get customer dropdown
    var handleCustomerDropdown = function () {
        $("#customer").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select customer",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/sample-request/customer",

                data: function (params) {
                    return {
                        _token: csrf_token,
                        search: params.term,
                        page: params.page || 1, // search term
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: true,
                        },
                    };
                },
            },
            templateResult: format,
            templateSelection: formatSelection,
        });
    };

    //select 2 main function
    function format(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }

    var handleDropdownAddressPic = function () {
        $("#customer").change(function (e) {
            e.preventDefault();
            const valueOfCustomer = $(this).val();
            $.ajax({
                type: "POST",
                url: url + "/sample-request/customer-detail",
                data: {
                    _token: csrf_token,
                    customer: valueOfCustomer,
                },
                dataType: "json",
                success: function (response) {
                    var items = response.items;
                    var customerPic = items.pic;
                    var customerAddress = items.address;

                    // Reset value and remove existing options for #customer-pic
                    $("#customer-pic").val(null).empty().trigger("change");

                    // Reset value and remove existing options for #customer-address
                    $("#customer-address").val(null).empty().trigger("change");

                    $("#customer-pic").select2({
                        data: customerPic,
                    });
                    $("#customer-address").select2({
                        data: customerAddress,
                    });
                },
            });
        });
    };

    return {
        init: function () {
            handleAdd();
            handleCustomerDropdown();
            handleDropdownAddressPic();
            getInfoCustomer();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
