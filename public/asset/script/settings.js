$(document).ready(function () {
    $(".sideBarli").removeClass("activeLi");
    $(".settingsSideA").addClass("activeLi");



    $("#paymentGatewayForm").on("submit", function (event) {
        event.preventDefault();

        var formdata = new FormData($("#paymentGatewayForm")[0]);
        $.ajax({
            url: domainUrl + "admin/updatePaymentSettings",
            type: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    iziToast.success({
                        title: strings.success,
                        message: strings.operationSuccessful,
                        position: "topRight",
                    });
                } else {
                    iziToast.error({
                        title: strings.error,
                        message: response.message,
                        position: "topRight",
                    });
                }
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            },
        });

    });

    $("#passwordForm").on("submit", function (event) {
        event.preventDefault();

        var formdata = new FormData($("#passwordForm")[0]);
        $.ajax({
            url: domainUrl + "admin/changePassword",
            type: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    iziToast.success({
                        title: strings.success,
                        message: strings.operationSuccessful,
                        position: "topRight",
                    });
                } else {
                    iziToast.error({
                        title: strings.error,
                        message: response.message,
                        position: "topRight",
                    });
                }
                $("#passwordForm").trigger("reset");
            },
            error: (error) => {
                $(".loader").hide();
                console.log(JSON.stringify(error));
            },
        });

    });

    $("#globalSettingsForm").on("submit", function (event) {
        event.preventDefault();
        $(".loader").show();

        var formdata = new FormData($("#globalSettingsForm")[0]);
        $.ajax({
            url: `${domainUrl}admin/updateGlobalSettings`,
            type: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $(".loader").hide();
                iziToast.success({
                    title: strings.success,
                    message: strings.operationSuccessful,
                    position: "topRight",
                });
            },
            error: (error) => {
                $(".loader").hide();
                console.log(JSON.stringify(error));
            },
        });

    });
});
