$(document).ready(function () {
    $(".sideBarli").removeClass("activeLi");
    $(".subAdminSideA").addClass("activeLi");

    $("#subAdminTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        bFilter: true,
        bInfo: false,
        aaSorting: [[0, "desc"]],
        columnDefs: [
            {
                targets: [4],
                orderable: false,
            },
        ],
        ajax: {
            url: `${domainUrl}admin/fetchSubAdminList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });


    $(document).on('click', '#submitForm', function () {
        $('#addSubAdminForm').submit();
    })

    $('#addSubAdminForm').validate({ // initialize the plugin
        rules: {
            fullName: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },

        },
        messages: {
            fullName: "Please enter a full name",
            email: {
                required: 'Please enter a email address',
                email: 'Enter a valid email address'
            }
        },
        submitHandler: function (form) {
            tinymce.triggerSave();
            var formdata = new FormData($("#addSubAdminForm")[0]);
            $.ajax({
                url: `${domainUrl}admin/addeditSubAdmin`,
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $(".loader").hide();

                    console.log(response);
                    if (response['status']) {
                        iziToast.success({
                            title: 'Success',
                            message: response['message'],
                            position: "topRight",
                            onClosing: function () {
                                window.location.href = `${domainUrl}admin/subadmins`
                            }
                        });
                    } else {
                        iziToast.error({
                            title: 'Error!',
                            message: response['message'],
                            position: "topRight",
                        });
                    }

                },
                error: (error) => {
                    $(".loader").hide();
                    console.log(JSON.stringify(error));
                },
            });
        }
    });


    $("#subAdminTable").on("click", ".delete", function (event) {
        event.preventDefault();
        swal({
            title: strings.doYouReallyWantToContinue,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((isConfirm) => {
            if (isConfirm) {

                var id = $(this).attr("rel");
                var url = `${domainUrl}admin/deleteSubAdmin` + "/" + id;

                $.getJSON(url).done(function (data) {
                    console.log(data);
                    $("#subAdminTable").DataTable().ajax.reload(null, false);
                    iziToast.success({
                        title: strings.success,
                        message: strings.operationSuccessful,
                        position: "topRight",
                    });
                });

            }
        });
    });

    $("#subAdminTable").on("click", ".changeStatus", function (event) {
        event.preventDefault();
        var id = $(this).attr("rel");
        var url = `${domainUrl}admin/changeSubAdminStatus` + "/" + id;

        $.getJSON(url).done(function (data) {
            console.log(data);
            $("#subAdminTable").DataTable().ajax.reload(null, false);
            iziToast.success({
                title: strings.success,
                message: strings.operationSuccessful,
                position: "topRight",
            });
        });

    });


});
