$(document).ready(function () {
    $(".sideBarli").removeClass("activeLi");
    $(".fileUploadsSideA").addClass("activeLi");

    $(document).on("change", "#upload_img", function () {

        var total_file = document.getElementById("upload_img").files.length;
        var regExp = new RegExp('image.(jpeg|jpg|gif|png|pdf|doc|docx|xls|xlsx)', 'i');
        var regExp = new RegExp("(.*?)\.(docx|doc|pdf|xml|xls|xlsx|jpg|png|gif|jpeg)$", 'i');
        var files = document.getElementById("upload_img").files;
        var game_image_size = $("#imgupload_ul").attr("data-size");
        var data = new FormData();
        for (var i = 0; i < total_file; i++) {
            var file = file = files[i];
            var matcher = regExp.test(file.name.toLowerCase());
            if ((!matcher) || (files[i].size > 2048)) {
                iziToast.error({
                    title: strings.error,
                    message: 'Invalid file format it allow only jpg,png...',
                    position: "topRight",
                });
                newdat = $('#imgupload_ul li:last').clone();
                var li_count = $("#imgupload_ul li").length - 1;
                $("#imgupload_ul").append(newdat);
                var outimg = assetUrl + "image/loadspin.gif";
                $('#imgupload_ul li:eq(' + li_count + ') .photo_preview_inner').html('<div class="photo_container" ><img class="loader_image_img loader_img_new" src="' + outimg + '" width="50" /></div>');
                $("#imgupload_ul li:eq(" + li_count + ")").removeClass('last_photo_li');
                $("#imgupload_ul li:eq(" + li_count + ")").remove();
            } else {
                data.append('photo[]', file);
                newdat = $('#imgupload_ul li:last').clone();
                var li_count = $("#imgupload_ul li").length - 1;
                $("#imgupload_ul").append(newdat);
                var outimg = assetUrl + "image/loadspin.gif";
                $('#imgupload_ul li:eq(' + li_count + ') .photo_preview_inner').html('<div class="photo_container" ><img class="loader_image_img loader_img_new" src="' + outimg + '" width="50" /></div>');
                $("#imgupload_ul li:eq(" + li_count + ")").removeClass('last_photo_li');

            }
        }


        $.ajax({
            url: domainUrl + "admin/uploadFile",
            type: "POST",
            data: data,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                var arr = [];
                if (data['status']) {
                    var array = (data['img']);
                    for (i = 0; i < array.length; i++) {


                        var total = array.length;
                        var overall_count = $('#imgupload_ul li').length - 1;
                        var resval = (parseInt(overall_count) - parseInt(total)) + parseInt(i);
                        //resval=resval-1;
                        //alert(resval);
                        var ext = array[i].split('.').pop();
                        if (ext == "pdf") {
                            var imgurl = assetUrl + "image/pdf.jpg";
                        } else if (ext == "docx" || ext == "doc") {
                            var imgurl = assetUrl + "image/word.jpg";
                        } else if (ext == "xls" || ext == "xlsx") {
                            var imgurl = assetUrl + "image/xls.jpg";
                        } else {
                            var imgurl = sourceUrl + array[i];
                        }
                        //alert($('#imgupload_ul li:eq(-3)').length);
                        $('#imgupload_ul li:eq(' + resval + ') .photo_preview_inner').html('<div class="responsive_img" style="background: url(' + imgurl + ')"></div><div class="default_photo default_photo_btn" data-img="' + array[i] + '"></div><div class="download_photo" ><a href="' + sourceUrl + array[i] + '" download=""><span class="fa fa-download"></span></a></div><div class="link_photo" data-name="' + array[i] + '"><a target="new" href="' + sourceUrl + array[i] + '" ><span class="fa fa-link"></span></a></div><div class="delete_photo" data-name="' + array[i] + '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20"><defs><path id="4xzqa" d="M390.14 599.1v1.82c0 .4-.32.72-.72.72h-1.35v10.7c0 .39-.33.71-.72.71H376.5a.72.72 0 0 1-.72-.72v-10.69h-1.35a.72.72 0 0 1-.72-.72v-1.82c0-1.1.9-1.99 2-1.99h4.34c.1-.28.37-.48.68-.48h2.38c.31 0 .57.2.67.48h4.36a2 2 0 0 1 1.99 2zm-3.51 2.54h-9.4v9.97h9.4zm2.07-1.44v-1.1c0-.3-.25-.55-.55-.55H375.7c-.3 0-.55.25-.55.55v1.1zm-9.38 8.2v-4.86a.72.72 0 1 1 1.44 0v4.86a.72.72 0 1 1-1.44 0zm3.78 0v-4.86a.72.72 0 1 1 1.44 0v4.86a.72.72 0 1 1-1.44 0z"></path></defs><g><g transform="translate(-372 -595)"><use fill="#fff" xlink:href="#4xzqa"></use></g></g></svg></div>');
                        $('#imgupload_ul li:eq(' + resval + ')').attr("data-img-name", array[i]);
                        $('#imgupload_ul li:eq(' + resval + ')').addClass("ui-sortable-handle");

                    }

                } else if (data['status']) {
                    var array = (data['img']);
                    for (i = 0; i < array.length; i++) {

                        var total = array.length;
                        var overall_count = $('#imgupload_ul li').length - 1;
                        var resval = (parseInt(overall_count) - parseInt(total)) + parseInt(i);
                        var img_name = array[i];
                        if (img_name == "error") {
                            $('#imgupload_ul li:eq(' + resval + ')').remove();
                        } else {
                            var total = array.length;
                            var overall_count = $('#imgupload_ul li').length - 1;
                            var resval = (parseInt(overall_count) - parseInt(total)) + parseInt(i);
                            //resval=resval-1;
                            //alert(resval);
                            var ext = array[i].split('.').pop();
                            if (ext == "pdf") {
                                var imgurl = assetUrl + "image/pdf.jpg";
                            } else if (ext == "docx" || ext == "doc") {
                                var imgurl = assetUrl + "image/word.jpg";
                            } else if (ext == "xls" || ext == "xlsx") {
                                var imgurl = assetUrl + "image/xls.jpg";
                            } else {
                                var imgurl = sourceUrl + array[i];
                            }
                            $('#imgupload_ul li:eq(' + resval + ').photo_preview_inner').html('<div class="responsive_img" style="background: url(' + imgurl + ')"></div><div class="default_photo default_photo_btn" data-img="' + array[i] + '"></div><div class="download_photo" ><a href="' + sourceUrl + array[i] + '" download=""><span class="icon icon-download"></span></a></div><div class="link_photo" data-name="' + array[i] + '"><a target="new" href="' + sourceUrl + array[i] + '" ><span class="fa fa-link"></span></a></div><div class="delete_photo" data-name="' + array[i] + '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20"><defs><path id="4xzqa" d="M390.14 599.1v1.82c0 .4-.32.72-.72.72h-1.35v10.7c0 .39-.33.71-.72.71H376.5a.72.72 0 0 1-.72-.72v-10.69h-1.35a.72.72 0 0 1-.72-.72v-1.82c0-1.1.9-1.99 2-1.99h4.34c.1-.28.37-.48.68-.48h2.38c.31 0 .57.2.67.48h4.36a2 2 0 0 1 1.99 2zm-3.51 2.54h-9.4v9.97h9.4zm2.07-1.44v-1.1c0-.3-.25-.55-.55-.55H375.7c-.3 0-.55.25-.55.55v1.1zm-9.38 8.2v-4.86a.72.72 0 1 1 1.44 0v4.86a.72.72 0 1 1-1.44 0zm3.78 0v-4.86a.72.72 0 1 1 1.44 0v4.86a.72.72 0 1 1-1.44 0z"></path></defs><g><g transform="translate(-372 -595)"><use fill="#fff" xlink:href="#4xzqa"></use></g></g></svg></div>');
                            $('#imgupload_ul li:eq(' + resval + ')').attr("data-img-name", array[i]);
                            $('#imgupload_ul li:eq(' + resval + ')').addClass("ui-sortable-handle");
                        }
                    }

                    iziToast.error({
                        title: strings.error,
                        message: data['message'],
                        position: "topRight",
                    });
                }
            }
        });
    });
    $(document).on("click", ".delete_photo", function () {
        var fname = $(this).attr('data-name');
        var lival = $(this);
        $.post(domainUrl + 'admin/delete_fileuploads', {
            'fname': fname
        }, function (data) {
            lival.closest('li').hide(500);
            setTimeout(function () {
                lival.closest('li').remove();
            }, 500);
        });
    });


});