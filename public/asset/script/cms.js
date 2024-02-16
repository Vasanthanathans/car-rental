$(document).ready(function () {
    $(".sideBarli").removeClass("activeLi");
    $(".CmsPagesSideA").addClass("activeLi");

    $("#cmsPagesTable").dataTable({
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
            url: `${domainUrl}admin/fetchCmsPageList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });


    $(document).on('click', '#submitForm', function () {
        $('#addCMSPageForm').submit();
    })

    $('#addCMSPageForm').validate({ // initialize the plugin
        rules: {
            title: {
                required: true,
            },

        },
        messages: {
            title: "Please enter a title"
        },
        submitHandler: function (form) {
            tinymce.triggerSave();
            var formdata = new FormData($("#addCMSPageForm")[0]);
            $.ajax({
                url: `${domainUrl}admin/addeditCmsPage`,
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
                                window.location.href = `${domainUrl}admin/cmsPages`
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


    $("#cmsPagesTable").on("click", ".delete", function (event) {
        event.preventDefault();
        swal({
            title: strings.doYouReallyWantToContinue,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((isConfirm) => {
            if (isConfirm) {

                var id = $(this).attr("rel");
                var url = `${domainUrl}admin/deleteCmspage` + "/" + id;

                $.getJSON(url).done(function (data) {
                    console.log(data);
                    $("#cmsPagesTable").DataTable().ajax.reload(null, false);
                    iziToast.success({
                        title: strings.success,
                        message: strings.operationSuccessful,
                        position: "topRight",
                    });
                });

            }
        });
    });

    $("#cmsPagesTable").on("click", ".changeStatus", function (event) {
        event.preventDefault();
        var id = $(this).attr("rel");
        var url = `${domainUrl}admin/changeStatus` + "/" + id;

        $.getJSON(url).done(function (data) {
            console.log(data);
            $("#cmsPagesTable").DataTable().ajax.reload(null, false);
            iziToast.success({
                title: strings.success,
                message: strings.operationSuccessful,
                position: "topRight",
            });
        });

    });


});
