$(document).ready(function () {
    $(".sideBarli").removeClass("activeLi");
    $(".bannersSideA").addClass("activeLi");

    $("#bannersTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        bFilter: false,
        bInfo: false,
        aaSorting: [[0, "desc"]],
        columnDefs: [
            {
                targets: [0, 1],
                orderable: false,
            },
        ],
        ajax: {
            url: `${domainUrl}admin/fetchBannersList`,
            data: function (data) {},
            error: (error) => {
                console.log(error);
            },
        },
    });

    $("#addBannerForm").on("submit", function (event) {
        event.preventDefault();
        $(".loader").show();
        var url = `${domainUrl}admin/addBanner`;
        if ($("#bannerId").val() != "") {
            url = `${domainUrl}admin/editBannerInfo`;
        }
        var formdata = new FormData($("#addBannerForm")[0]);
     
        $.ajax({
            url: url,
            type: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $(".loader").hide();
                $("#addBannerModal").modal("hide");
                $("#addBannerForm").trigger("reset");
                $("#bannersTable").DataTable().ajax.reload(null, false);
                $("#bannerId").val('')
                $("#bannerTitle").val('');
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

    $("#bannersTable").on("click", ".delete", function (event) {
        event.preventDefault();
        swal({
            title: strings.doYouReallyWantToContinue,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((isConfirm) => {
            if (isConfirm) {
                var id = $(this).attr("rel");
                var url = `${domainUrl}admin/deleteBanner` + "/" + id;

                $.getJSON(url).done(function (data) {
                    console.log(data);
                    $("#bannersTable").DataTable().ajax.reload(null, false);
                    iziToast.success({
                        title: strings.success,
                        message: strings.operationSuccessful,
                        position: "topRight",
                    });
                });
            }
        });
    });

    $("#categoriesTable").on("click", ".edit", function (event) {
        event.preventDefault();

        var title = $(this).data("title");
        var icon = $(this).data("icon");
        var id = $(this).attr("rel");

        $("#editSalonCatId").val(id);
        $("#editSalonCatTitle").val(title);
        $("#imgSalonCat").attr("src", icon);

        $("#editSalonCatModal").modal("show");
    });

    $(document).on("click", ".update", function () {
        var id = $(this).attr("rel");
        var title = $(this).attr("data-title");
        $("#bannerTitle").val(title);
        $("#bannerId").val(id);
        $('#addBannerModal').modal('show');
    });
});
