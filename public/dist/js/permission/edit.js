var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    let modulevalue;

    var handleInputTag = function () {
        $("#fungsi-sa").tagsinput();
        $("#fungsi-lab").tagsinput();
        $("#fungsi-reg").tagsinput();
    };

    // function when tab super admin event click
    var handleSaTab = function () {
        $("#super-admin-tab").on("click", function () {
            const groupValue = $(this).data("group");
            $("#group-value-sa").val(groupValue);
            modulevalue = $(".module-value-custom").val();

            $.ajax({
                type: "POST",
                url: url + "/permission-management/permission",
                data: {
                    _token: csrf_token,
                    mValue: modulevalue,
                    gValue: groupValue,
                },
                dataType: "json",
                success: function (response) {
                    let responseData = response.data;

                    $("#is-akses-sa").append(
                        $("<option>", {
                            value: responseData.id,
                            text: responseData.text,
                            attr: "selected",
                        })
                    );
                    $("#form-value-sa").val(responseData.formValue);
                    $("#fungsi-sa").tagsinput("add", responseData.fungsi);

                    $("#btnSaUpdate").removeAttr("disabled");

                    handleSelectSa();
                },
                error: function (response) {
                    Swal.fire({
                        title: "Data not found",
                        text: "Return to Permission Management Dashboard",
                        icon: "question",
                    });
                },
            });
        });
    };
    // function when tab lab user event click
    var handleLabTab = function () {
        $("#lab-user-tab").on("click", function () {
            const groupValue = $(this).data("group");
            $("#group-value-lab").val(groupValue);
            modulevalue = $(".module-value-custom").val();

            $.ajax({
                type: "POST",
                url: url + "/permission-management/permission",
                data: {
                    _token: csrf_token,
                    mValue: modulevalue,
                    gValue: groupValue,
                },
                dataType: "json",
                success: function (response) {
                    let responseData = response.data;

                    $("#is-akses-lab").append(
                        $("<option>", {
                            value: responseData.id,
                            text: responseData.text,
                            attr: "selected",
                        })
                    );
                    $("#form-value-lab").val(responseData.formValue);
                    $("#fungsi-lab").tagsinput("add", responseData.fungsi);
                    $("#btnLabUpdate").removeAttr("disabled");

                    handleSelectLab();
                },
                error: function (response) {
                    Swal.fire({
                        title: "Data not found",
                        text: "Return to Permission Management Dashboard",
                        icon: "question",
                    });
                },
            });
        });
    };
    // function when tab reguler user event click
    var handleReqTab = function () {
        $("#reguler-user-tab").on("click", function () {
            const groupValue = $(this).data("group");
            $("#group-value-reg").val(groupValue);
            modulevalue = $(".module-value-custom").val();

            $.ajax({
                type: "POST",
                url: url + "/permission-management/permission",
                data: {
                    _token: csrf_token,
                    mValue: modulevalue,
                    gValue: groupValue,
                },
                dataType: "json",
                success: function (response) {
                    let responseData = response.data;

                    $("#is-akses-reg").append(
                        $("<option>", {
                            value: responseData.id,
                            text: responseData.text,
                            attr: "selected",
                        })
                    );
                    $("#form-value-reg").val(responseData.formValue);
                    $("#fungsi-reg").tagsinput("add", responseData.fungsi);
                    $("#btnRegUpdate").removeAttr("disabled");

                    handleSelectReg();
                },
                error: function (response) {
                    Swal.fire({
                        title: "Data not found",
                        text: "Return to Permission Management Dashboard",
                        icon: "question",
                    });
                },
            });
        });
    };

    // select 2 for super admin
    var handleSelectSa = function () {
        var dataPermissionSa = [
            {
                id: "1",
                text: "Yes",
            },
            {
                id: "0",
                text: "No",
            },
        ];

        $("#is-akses-sa").select2({
            data: dataPermissionSa,
        });
    };
    // select 2 for lab user
    var handleSelectLab = function () {
        var dataPermissionLab = [
            {
                id: "1",
                text: "Yes",
            },
            {
                id: "0",
                text: "No",
            },
        ];

        $("#is-akses-lab").select2({
            data: dataPermissionLab,
        });
    };
    // select 2 for reguler user
    var handleSelectReg = function () {
        var dataPermissionReg = [
            {
                id: "1",
                text: "Yes",
            },
            {
                id: "0",
                text: "No",
            },
        ];

        $("#is-akses-reg").select2({
            data: dataPermissionReg,
        });
    };

    var handleUpdateSa = function () {
        $("#form-permission-superadmin").submit(function (e) {
            e.preventDefault();

            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/permission/update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            reload();
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
    var handleUpdateLab = function () {
        $("#form-permission-lab").submit(function (e) {
            e.preventDefault();

            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/permission/update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            reload();
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
    var handleUpdateReg = function () {
        $("#form-permission-reguler").submit(function (e) {
            e.preventDefault();

            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/permission/update",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            reload();
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
            handleLabTab();
            handleReqTab();
            handleSaTab();

            handleUpdateSa();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
