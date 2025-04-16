
function resizeEmbedIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

(function () {
    window.postDescription = "";
    var baseUrl = $("body").attr("data-baseurl"), videoOptionData = '';
    tempPath = baseUrl + '/admin/ajax-templates/',
        attemptedUploads = [],
        errorFlag = false,
        httpRequest = function (route, method, data, isDataType) {
        var deferredObject = $.Deferred(), options = {url: baseUrl + route, type: method, data: data,};
        if (isDataType)
            options["dataType"] = "JSON";
        var request = $.ajax(options);
        request.done(function (response) {
            deferredObject.resolve(response);
        });
        request.fail(function (response) {
            deferredObject.reject(response);
        });
        return deferredObject.promise();
    };
    readURL = function (input, img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.attr('src', e.target.result);
                img.show();
                if (img.hasClass("fullstory-display-img")) {
                    $(".fullstory-uploader .img-placeholder").hide();
                } else {
                    $(".featured-uploader .img-placeholder").hide();
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }, adjustSortOrder = function () {
        $(".edit-box").each(function (i) {
            var el = $(this), orderval = i + 1;
            el.attr("data-sort", orderval);
            el.find(".pos-counter").remove();
            el.append("<span class='pos-counter'>" + orderval + "</span>");
        });
    }, loadTemplate = function (templetFile, callback) {
        var templet = tempPath + templetFile + '?a=' + Math.random();
        $.get(templet, function (data) {
            callback(data);
        });
    }, editorInt = function (ele) {
        var opoint = {
            pluginsEnabled: ['colors'],
            height: 200,
            placeholderText: 'Add Discription',
            toolbarButtons: ['bold', 'italic', 'underline', 'fontSize', 'color']
        }, e = $(ele);
        var ed = e.froalaEditor(opoint);
    };
    appendEditor = function (data) {
        var editorCount = ($('.appneNewAditor').find('textarea').length + 1),
            titleName = 'description[title' + editorCount + ']', editorName = 'description[editor' + editorCount + ']';
        var template = $(data);
        $(template).find('textarea').addClass('editor' + editorCount);
        $('.appneNewAditor').append(template);
        editorInt($('.appneNewAditor').find('.editor' + editorCount));
    };
    appendImageGallery = function (data) {
        var editorCount = ($(".appneNewAditor").find('.gallery').length + 1),
            editorName = 'description[editorgallery' + editorCount + ']', template = $(data);
        $(template).find('textarea').addClass('editorgallery' + editorCount);
        $('.appneNewAditor').append(template);
        editorInt($('.appneNewAditor').find('.editorgallery' + editorCount));
    }, appendImage = function (data) {
        var editorCount = ($(".appneNewAditor").find('.gallery').length + 1),
            editorName = 'description[editorimage' + editorCount + ']', template = $(data);
        $(template).find('textarea').addClass('editorimage' + editorCount);
        $('.appneNewAditor').append(template);
        editorInt($('.appneNewAditor').find('.editorimage' + editorCount));
    }, validateImage = function (i, file) {
        var errorFlag = true;
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
            errorFlag = false;
        }
        return errorFlag;
    }, previewImages = function () {
        var ele = $(this), eleType = ele.attr('data-type'),
            $preview = ele.parents('.edit-box').find('.gallery-inner-preview');
        if (eleType == 'gallery') {

            var orderCount = ele.parents('.edit-box').find('.gallaryPreview').length;
            var readAndPreview = function (i, file) {
                var errorFlag = validateImage(i, file);

                if (!!errorFlag) {
                    var reader = new FileReader();
                    $(reader).on("load", function () {
                        var imageSrc = this.result;
                        loadTemplate('imagePreview', function (data) {
                            var previewTemplate = $(data);
                            $(previewTemplate).find('img').attr('src', imageSrc).addClass('previewimage');
                            $(previewTemplate).find('input.title').attr('name', 'gallaryimagename' + (i + 1)).addClass('gimage');
                            $(previewTemplate).find('input.order').attr('name', 'order' + (i + 1)).addClass('gorder').val(0);
                            $(previewTemplate).find('a').attr('name', i).addClass('removeImage').html('X');
                            $preview.append(previewTemplate);
                        });
                    });
                    reader.readAsDataURL(file);
                }else{
                    alert('Invalid format');
                }
            }
            if (this.files) $.each(this.files, readAndPreview);
        } else if (eleType == 'single') {
            var file = this.files[0], reader = new FileReader();
            $(reader).on("load", function (e) {
                ele.parents('.gallery').find('.img-placeholder').css({display: 'none'});
                var imageSrc = e.target.result;
                if (ele.parents('.gallery').find('.singlePreview').length == 0) {
                    loadTemplate('singleImagePreview', function (data) {
                        var previewTemplate = $(data);
                        $(previewTemplate).find('img').attr('src', imageSrc).addClass('singlepreviewimage');
                        $(previewTemplate).find('a').attr('name', 'sinlgeimagetitle').addClass('removeImage').html('X');
                        $preview.append(previewTemplate);
                    });
                } else {
                    ele.parents('.gallery').find('.singlePreview').find('img').attr('src', imageSrc);
                }
            });
            reader.readAsDataURL(file);
        }
    }, appendPlaylist = function (data) {
        var template = $(data), editorCount = ($(".appneNewAditor").find('.play_list').length + 1);
        $(template).find('textarea').addClass('playlistbox' + editorCount);
        $(template).find('select').append($(videoOptionData));
        $('.appneNewAditor').append(template);
        editorInt($('.appneNewAditor').find('.playlistbox' + editorCount));
    }, getImageNameFromURL = function (url) {
        var urlArr = url.toString().split("/");
        return urlArr[urlArr.length - 1];
    }, appendIframe = function (data) {
        var template = $(data);
        $('.appneNewAditor').append(template);
    }, appendvideo = function (data, alreadyAppend) {
        var template = $(data);
        if (!alreadyAppend)
            $(template).find('select').append($(videoOptionData));
        $('.appneNewAditor').append(template);
    }, addMorePlaylist = function () {
        var ele = $(this), listArea = ele.parents('.edit-box').find('.form-element.list');
        loadTemplate('playlist', function (data) {
            var template = $(data);
            $(template).find('select').append($(videoOptionData));
            var listItem = $(template).find('.list-item').clone();
            listArea.append(listItem);
        });
    }, deletePlayList = function () {
        var ele = $(this), id = ele.attr('data-id'), playListId = ele.parents('.edit-box').attr('data-id');
        console.log(ele.parents('edit-box'));
        if (typeof id !== 'undefined') {
            var postData = {video_id: id, playlist_id: playListId};
            var data = httpRequest('geonewimages/content/posts/ajax_delete_playlist_video', 'post', postData, true);
        }
        ele.parents('.list-item').remove();
    }, deleteImage = function (e) {
        var ele = $(this),
            id = ele.attr('data-id'),
            dataTime = ele.attr('data-datetime');
        if (ele.hasClass('singleimage')) {
            ele.parents('.singlePreview').remove();
        } else {
            if (typeof id !== 'undefined') {
                var postData = {
                    image_id: id,
                    data_time: dataTime,
                    gallery_id: ele.parents(".edit-box").attr("data-id"),
                    post_id: $("body").find("#post_description").attr("data-id"),
                    image_name: getImageNameFromURL(ele.parents(".gallaryPreview").find("img").attr("src"))
                };
                var data = httpRequest('/admin/gallery/ajax_delete_gallery_image', 'post', postData, true);
            }
            ele.parents('.gallaryPreview').remove();
        }
    }, validateBasicInfo = function () {
        errorFlag = false;
        var errorTxt = '';
        $(".edit-box").each(function () {
            var el = $(this), data = {}, errorEle = el.find('.alert-danger'), dataType = el.attr("data-type");
            data["type"] = dataType;
            if (dataType == "imagegallery") {
                errorFlag = false;
                errorEle.addClass('hide').find('.errors').html('');
                if (el.find("[name='title']").val() == '') {
                    errorEle.removeClass('hide').find('.errors').append("<strong>Error!</strong> Please enter gallery title.");
                    errorFlag = true;
                }
                if (el.find(".gallaryPreview").length <= 0) {
                    errorEle.removeClass('hide').find('.errors').append("<strong>Error!</strong> Please select imges to upload");
                    errorFlag = true;
                }
            } else if (dataType == "playlist") {
                errorFlag = false;
                errorEle.addClass('hide').find('.errors').html('');
                if (el.find("[name='title']").val() == '') {
                    errorEle.removeClass('hide').find('.errors').append("<strong>Error!</strong> Please enter gallery title.");
                    errorFlag = true;
                }
                if (el.find(".list-item").length <= 0) {
                    errorEle.removeClass('hide').find('.errors').append("<strong>Error!</strong> Please enter url");
                    errorFlag = true;
                }
                el.find(".list-item").each(function () {
                    if ($(this).find('[name="playlisturl"]').val() == '') {
                        errorEle.removeClass('hide').find('.errors').append("<strong>Error!</strong> Please enter url");
                        errorFlag = true;
                    }
                });
            }
        });
        return errorFlag;
    }, sendPost = function (eleBtn) {
        var postData = {};
        postData["postDescription"] = [];
        $('.edit-loader-area').removeClass('hide');
        postData["post_edit_id"] = $('[data-name="post_edit_id"]').val();
        $(".edit-box").each(function () {
            var el = $(this), data = {}, dataType = el.attr("data-type");
            if (dataType != "singlevideo" && dataType != "iframe") {
                data["title"] = el.find('[name="title"]').val();
                data["description"] = el.find('[name="description"]').val();
            }
            data["id"] = null;
            if (typeof el.attr('data-id') !== 'undefined') {
                data["id"] = el.attr('data-id');
            }
            if (typeof el.find('[name="postdata_time"]') !== 'undefined') {
                data["postdate_time"] = el.find('[name="postdata_time"]').val();
            }
            data["type"] = dataType;
            if (dataType == "imagegallery") {
                data["gallery_images"] = [];
                el.find(".gallaryPreview").each(function () {
                    var base64Img = $(this).find("img[src*='base64']").length, imagesData = {};
                    imagesData["id"] = (typeof $(this).find("[name='id']").val() !== 'undefined') ? $(this).find("[name='id']").val() : null;
                    imagesData["title"] = $(this).find(".gimage").val();
                    imagesData["order"] = $(this).find(".gorder").val();
                    imagesData["src"] = $(this).find(".previewimage").attr("src");
                    if (base64Img > 0) {
                    } else {
                        imagesData["src"] = '';
                    }
                    data["gallery_images"].push(imagesData);
                });
            } else if (dataType == "singleimage") {
                var base64Img = el.find(".picture-uploader img[src*='base64']").length;
                if (base64Img > 0) {
                    data["image"] = el.find(".picture-uploader .singlepreviewimage").attr("src");
                } else {
                    data["image"] = null;
                }
            } else if (dataType == "playlist") {
                data["playlist"] = [];
                el.find(".list-item").each(function () {
                    var listData = {};
                    listData["id"] = $(this).find("[name='id']").val();
                    listData["videourl"] = $(this).find('[name="playlisturl"]').val();
                    listData["videotype"] = $(this).find('[name="playlisttype"]').val();
                    data["playlist"].push(listData);
                });
            } else if (dataType == "singlevideo") {
                data["title"] = el.find('[name="title"]').val();
                data["videourl"] = el.find(".list-item").find('[name="videourl"]').val();
                data["videotype"] = el.find(".list-item").find('[name="videotype"]').val();
            } else if (dataType == "iframe") {
                data["title"] = el.find('[name="title"]').val();
                data["embed_code"] = el.find('[name="iframe"]').val();
            }
            postData["postDescription"].push(data);
        });
        postData["save"] = 1;
        if (!errorFlag) {
            $(eleBtn).attr("disabled", true);
            $.ajax({
                "data": postData,
                "type": "post",
                "url": $("#create_form").attr("action"),
                success: function (data) {
                    $('.edit-loader-area').addClass('hide');
                    window.location.reload();
                    $(eleBtn).attr("disabled", false);
                },
                complete: function () {
                    $('.edit-loader-area').addClass('hide');
                    $(eleBtn).attr("disabled", false);
                }
            });
        }
    }, setupData = function (data) {
        $.each(data, function (i, v) {
            var type = v["type"];
            console.log(type);
            loadTemplate(type, function (data) {
                var template = $(data);
                template.find("[name='title']").val(v["title"]);
                if (typeof v["id"] !== "undefined") {
                    template.attr("data-id", v["id"]);
                    template.find(".close-edit-box").attr("data-id", v["id"]);
                }
                switch (type) {
                    case'texteditor':
                        template.find("textarea").val(v["description"]);
                        appendEditor(template);
                        break;
                    case'imagegallery':
                        template.find("textarea").val(v["description"]);
                        $.each(v["gallery_images"], function (e, val) {
                            loadTemplate('imagePreview', function (data) {
                                var previewTemplate = $(data);
                                $(previewTemplate).find('img').attr('src', val["src"]).addClass('previewimage');
                                $(previewTemplate).find('input:text').attr('name', 'gallaryimagename' + (i + 1)).addClass('gimage').val(val["title"]);
                                $(previewTemplate).find("input[name='id']").val(val["id"]);
                                $(previewTemplate).find('a').attr('name', i).addClass('removeImage').attr('data-id', val["id"]).html('X');
                                template.find('.gallery-inner-preview').append(previewTemplate);
                            });
                        });
                        appendImageGallery(template);
                        if (v["description"]) {
                            template.find('.detail-more').trigger('click');
                        }
                        break;
                    case'playlist':
                        template.find("textarea").val(v["description"]);
                        template.find('.list-item').remove();
                        $.each(v["playlist"], function (e, val) {
                            loadTemplate('playlist', function (data) {
                                var templateInner = $(data);
                                templateInner.find('a').attr('data-id', val["id"]);
                                templateInner.find('select').append($(videoOptionData));
                                templateInner.find('option[value="' + val["videotype"] + '"]').attr("selected", "selected");
                                templateInner.find("input[name='id']").val(val["id"]);
                                var listItem = templateInner.find('.list-item').clone();
                                listItem.find('[name="playlisturl"]').val(val["videourl"]);
                                template.find('.form-element.list').append(listItem);
                            });
                        });
                        appendPlaylist(template);
                        if (v["description"]) {
                            template.find('.detail-more').trigger('click');
                        }
                        break;
                    case'iframe':
                        template.find("textarea").val(v["description"]);
                        appendIframe(template);
                        break;
                    case'singlevideo':
                        template.find("[name='videourl']").val(v["videourl"]);
                        setTimeout(function () {
                            template.find('select').append($(videoOptionData));
                            template.find('option[value="' + v["videotype"] + '"]').attr("selected", "selected");
                        }, 100);
                        appendvideo(template, true);
                        break;
                    case'singleimage':
                        template.find("textarea").val(v["description"]);
                        loadTemplate('singleImagePreview', function (data) {
                            var previewTemplate = $(data);
                            $(previewTemplate).find('img').attr('src', v["image"]).addClass('singlepreviewimage');
                            $(previewTemplate).find('a').attr('name', 'sinlgeimagetitle').addClass('removeImage').html('X');
                            template.find('.img-placeholder').css('display', 'none');
                            template.find('.gallery-inner-preview').append(previewTemplate);
                            if (v["description"]) {
                                template.find('.detail-more').trigger('click');
                            }
                        });
                        appendImage(template);
                        break;
                }
            });
        })
    };
    $(function () {
        var descriptionEle = $("body").find("#post_description");
        if (typeof descriptionEle.attr("id") !== "undefined") {
            var post_id = descriptionEle.attr("data-id"), route = descriptionEle.attr("data-route");
            console.log('geonewimages/content/posts/' + route + "/" + post_id);
            var data = httpRequest('geonewimages/content/posts/' + route + "/" + post_id, 'post', "", true);
            data.done(function (response) {
                console.log(response);
                postDescription = response;
                setupData(response);
            });
        }
        $('[name="featured_image"]').on("change", function () {
            readURL(this, $(".featured-display-img"));
        });
        $('[name="fullstory_image"]').on("change", function () {
            readURL(this, $(".fullstory-display-img"));
        });
        $('.form-area').on("click", ".close-edit-box", function () {
            var ele = $(this), id = ele.attr("data-id"), type = ele.parents(".edit-box").attr("data-type");
            if (typeof id !== "undefiend") {
                var requestUrl = '', postData = "", post_id = $("body").find("#post_description").attr("data-id"),
                    sectionID = ele.parents(".edit-box").attr("data-id");
                if (type == "playlist") {
                    requestUrl = 'geonewimages/content/posts/ajax_delete_playlist';
                    postData = {playlist_id: sectionID, post_id: post_id};
                } else if (type == "imagegallery") {
                    requestUrl = 'geonewimages/content/posts/ajax_delete_gallery';
                    postData = {gallery_id: sectionID, post_id: post_id};
                } else if (type == "singleimage") {
                    requestUrl = 'geonewimages/content/posts/ajax_delete_post_image';
                    postData = {image_id: sectionID, post_id: post_id};
                } else if (type == "singlevideo") {
                    requestUrl = 'geonewimages/content/posts/ajax_delete_post_video';
                    postData = {video_id: sectionID, post_id: post_id};
                } else if (type == "texteditor" || type == "iframe") {
                    requestUrl = 'geonewimages/content/posts/ajax_delete_textdata';
                    postData = {text_id: sectionID, post_id: post_id};
                }
                if (requestUrl !== "" && postData !== "")
                    var data = httpRequest(requestUrl, 'post', postData, true);
            }
            $(this).parents(".edit-box").remove();
        });
        $('.form-area').on("click", ".detail-more", function () {
            if ($(this).attr("data-hide") == "true") {
                $(this).parents(".imageEditor,.playListEditor").find(".form-element").removeClass("hide");
                $(this).attr("data-hide", false);
                $(this).text("Less Details");
            } else {
                $(this).parents(".imageEditor,.playListEditor").find(".form-element").addClass("hide");
                $(this).attr("data-hide", true);
                $(this).text("More Details");
            }
        });
        $(".form-area").on("click", ".sort-icon", function () {
            var ele = $(this), selectedEditor = ele.parents(".edit-box"), editorPrev = selectedEditor.prev(".edit-box"),
                editorNext = selectedEditor.next(".edit-box");
            if (ele.hasClass("sort-up")) {
                selectedEditor.insertBefore(editorPrev);
            } else {
                selectedEditor.insertAfter(editorNext);
            }
            $(window).scrollTop(selectedEditor.position().top);
            adjustSortOrder();
        });
        $(window).scroll(function () {
            var scrollPosition = $(window).scrollTop(), elePosition = $(".left-area").position().top;
            if (scrollPosition + 60 >= elePosition) {
                $(".right-area .right-area-scroll").addClass("scrolling");
            } else {
                $(".right-area .right-area-scroll").removeClass("scrolling");
            }
        });
        $(".addElement").on('click', function () {
            var templateName = $(this).attr('data-templatetype');
            loadTemplate(templateName, function (data) {
                var template = $(data);
                switch (templateName) {
                    case'texteditor':
                        appendEditor(template);
                        break;
                    case'imagegallery':
                        appendImageGallery(template);
                        break;
                    case'playlist':
                        appendPlaylist(template);
                        break;
                    case'iframe':
                        appendIframe(template);
                        break;
                    case'singlevideo':
                        appendvideo(template);
                        break;
                    case'singleimage':
                        appendImage(template);
                        break;
                }
            });
        });
        if (typeof descriptionEle.attr("id") == "undefined" && descriptionEle.attr("data-id") == "") {
            $('[data-templatetype="texteditor"]').trigger("click");
        }
        $('form .appneNewAditor').on('change', 'input:file', previewImages);
        $(document).on('click', 'form .removeImage', deleteImage);
        $(document).on('click', 'form .addMorePlayList', addMorePlaylist);
        $(document).on('click', 'form .deletePlayList', deletePlayList);
        $(".form-area").on('click', '.send-post', function () {
            var ele = $(this);
            var errorFlag = validateBasicInfo();
            if (!errorFlag) {
                sendPost(ele);
            }
        });
        $(".form-area").on('click', '.action-area', function () {
            if ($(this).hasClass("show_slug")) {
                if ($(".slug-area").hasClass("hide")) {
                    $(".slug-area").removeClass("hide");
                    $(this).text("Change Slug X");
                } else {
                    $(".slug-area").addClass("hide");
                    $(this).text("Change Slug");
                }
            } else {
                if ($(".alt-area").hasClass("hide")) {
                    $(".alt-area").removeClass("hide");
                    $(this).text("Add Alt Title X");
                } else {
                    $(".alt-area").addClass("hide");
                    $(this).text("Add Alt Title");
                }
            }
        });

        function doc_keyUp(e) {
            if (e.ctrlKey && e.keyCode == 83) {
                console.log('123312----123123');
                $('body').find('[data-templatetype="editor"]').trigger('click');
            }
        }

        document.addEventListener('keyup', doc_keyUp, false);
    });
}());
