function resizeEmbedIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

function reset_form_element(e) {
    e.wrap('<form>').parent('form').trigger('reset');
    e.unwrap();
}

(function () {

    window.postDescription = "";
    var baseUrl = $("body").attr("data-baseurl"), videoOptionData = '';
    tempPath = baseUrl + '/themes/admin/templates/', attemptedUploads = [], errorFlag = false,

        httpRequest = function (route, method, data, isDataType) {

            var deferredObject = $.Deferred(),
                options = {
                    url: baseUrl + route,
                    type: method,
                    data: data,
                };

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



    loadTemplate = function (templetFile, callback) {

        var templet = tempPath + templetFile + '.html?a=' + Math.random();

        $.get(templet, function (data) {
            callback(data);
        });

    },

        //todo: init editor ----'quickInsert'

        editorInt = function (ele) {
            var opoint = {
                    pluginsEnabled: ['align', 'charCounter', 'codeBeautifier', 'codeView', 'colors', 'draggable', 'emoticons', 'entities', 'file', 'fontFamily', 'fontSize', 'fullscreen', 'image', 'imageManager', 'inlineStyle', 'lineBreaker', 'link', 'lists', 'paragraphFormat', 'paragraphStyle', 'quote', 'save', 'table', 'url', 'video', 'wordPaste'],
                    height: 200,
                    placeholderText: 'Add Discription',
                    toolbarButtons: ['bold', 'italic', 'underline', 'fontSize', 'color', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'quote', 'insertHR', 'insertLink', 'insertTable', 'video']
                },
                e = $(ele);
            var ed = e.froalaEditor(opoint);

        };

    appendEditor = function (data) {

        var editorCount = ($('.appneNewAditor').find('textarea').length + 1),
            titleName = 'description[title' + editorCount + ']',
            editorName = 'description[editor' + editorCount + ']';

        var template = $(data);

        /*$(template).find('input').attr('name', titleName);
        $(template).find('textarea').attr('name', editorName);*/
        $(template).find('textarea').addClass('editor' + editorCount);

        $('.appneNewAditor').append(template);

        editorInt($('.appneNewAditor').find('.editor' + editorCount));

    };

    appendImageGallery = function (data) {

        var editorCount = ($(".appneNewAditor").find('.gallery').length + 1),
            editorName = 'description[editorgallery' + editorCount + ']',
            template = $(data);

        /*$(template).find('textarea').attr('name', editorName);*/
        $(template).find('textarea').addClass('editorgallery' + editorCount);

        $('.appneNewAditor').append(template);

        editorInt($('.appneNewAditor').find('.editorgallery' + editorCount));

    },

        appendImage = function (data) {

            var editorCount = ($(".appneNewAditor").find('.gallery').length + 1),
                editorName = 'description[editorimage' + editorCount + ']',
                template = $(data);

            /*$(template).find('textarea').attr('name', editorName);*/
            $(template).find('textarea').addClass('editorimage' + editorCount);

            $('.appneNewAditor').append(template);

            editorInt($('.appneNewAditor').find('.editorimage' + editorCount));

        },





        $(function () {



            /**edit**/
            var descriptionEle = $("body").find("#post_description");






            // //Add Elements
            // $(".addElement").on('click', function () {
            //     var templateName = $(this).attr('data-templatetype');
            //
            //     loadTemplate(templateName, function (data) {
            //
            //         var template = $(data);
            //
            //         switch (templateName) {
            //             case 'texteditor':
            //                 appendEditor(template);
            //                 break;
            //             case 'imagegallery':
            //                 appendImageGallery(template);
            //                 break;
            //             case 'playlist':
            //                 appendPlaylist(template);
            //                 break;
            //             case 'iframe':
            //                 appendIframe(template);
            //                 break;
            //             case 'singlevideo':
            //                 appendvideo(template);
            //                 break;
            //             case 'singleimage':
            //                 appendImage(template);
            //                 break;
            //         }
            //
            //     });
            //
            // });

            //Dynamic Inputs click Events

            //file input change event
            // $('form .appneNewAditor').on('change', 'input:file', previewImages);

            // Attach on click listener which will handle the removing of images.
            // $(document).on('click', 'form .removeImage', deleteImage);

            //addMore Playlist
//        $(document).on('click', 'form .addMorePlayList', addMorePlaylist);

            //Delete Playlist
            //      $(document).on('click', 'form .deletePlayList', deletePlayList);

            //Send Post
            //$(".form-area").on('click', '.send-post', sendPost);







            var editor = new MediumEditor('.editable', {
                buttonLabels: 'fontawesome',
                toolbar: {
                    buttons: [
                        'h1',
                        'h2',
                        'h3',
                        'bold',
                        'italic',
                        'quote',
                        'anchor',
                        'unorderedlist',
                        'orderedlist',
                        'colorPicker',
                        'strikethrough',
                        'unorderedlist',
                        'orderedlist',
                        'justifyLeft',
                        'span',
                        'table',
                        'customHtml',
                        'fontsize'

                    ]
                },
                anchor: {
                    targetCheckbox: true,
                    nofollowCheckbox: true,
                    linkValidation: true,
                    targetCheckboxText: 'Open In New Window'
                },
                paste: {
                    forcePlainText: true,
                    cleanPastedHTML: false,
                    cleanReplacements: [],
                    cleanAttrs: ['class', 'style', 'dir'],
                    cleanTags: ['meta'],
                    unwrapTags: []
                },
                extensions: {
                    colorPicker: pickerExtension,
                    table: new MediumEditorTable(),
                    "customHtml": new CustomHtml({
                        buttonText: '<hr>'
                        , htmlToInsert: "<hr class='editorHr'>"
                    })
                    //Play Button

                    /*embedButton: new EmbedButtonExtension({
                        embedOpts: {
                            oembedProxy: "http://iframe.ly/api/oembed?api_key=3bef8c4238179ff9306315&url="
                        }
                    })*/
                }
            });

            $(function () {
                $('.editable').mediumInsert({
                    editor: editor,
                    addons: {

                    }
                });
            });
            var oldpostid = $('.editable').attr('data-oldpostid');

            if (oldpostid == 'false') {
                var tweetObj = document.getElementsByClassName('tweetPost');

                if (tweetObj.length == 0) {
                    tweetObj = document.getElementsByClassName('twitter-tweet');
                    $.each(tweetObj, function (i, v) {
                        $(this).attr('id', 'twitter-post-widget-' + i);
                    });
                } else {
                    $.each(tweetObj, function (i, v) {
                        $(this).find('.twitter-tweet').attr('id', 'twitter-post-widget-' + i);
                    });
                }
                $.getScript('//platform.twitter.com/widgets.js', function () {
                    var k = 0;
                    var tweet = document.getElementById('twitter-post-widget-' + k);
                    var tweetParent, tweetID;
                    while (tweet) {
                        tweetParent = tweet.parentNode;
                        //tweetID = tweet.dataset.tweetId;
                        tweetID = tweetParent.getAttribute("id");
                        console.log(tweetID+'--Postid');
                        //var tweetVideoClass = tweet.getAttribute('class').split(' ')[0];
                        $(tweet).remove();
                        twttr.widgets.createTweet(
                            tweetID,
                            tweetParent
                        );
                        k++;
                        tweet = document.getElementById('twitter-post-widget-' + k);
                    }
                });

                /*==============*/

                var tweetObjVid = document.getElementsByClassName('tweetVideo');

                if (tweetObjVid.length == 0) {
                    tweetObjVid = document.getElementsByClassName('twitter-video');
                    $.each(tweetObjVid, function (i, v) {
                        $(this).attr('id', 'twitter-vid-widget-' + i);
                    });
                } else {
                    $.each(tweetObjVid, function (i, v) {
                        var tweetEleLen = $(this).find('.twitter-video').length;
                        $(this).find('.twitter-video').attr('id', 'twitter-vid-widget-' + i);
                    });
                }
                $.getScript('//platform.twitter.com/widgets.js', function () {
                    var v = 0;
                    var tweetVid = document.getElementById('twitter-vid-widget-' + v);
                    var tweetParentVid, tweetIDVid;
                    while (tweetVid) {
                        tweetParentVid = tweetVid.parentNode;
                        //tweetIDVid = tweetVid.dataset.tweetId;
                        tweetIDVid = tweetParentVid.getAttribute("id");
                        console.log(tweetIDVid);
                        $(tweetVid).remove();
                        twttr.widgets.createVideo(
                            tweetIDVid,
                            tweetParentVid
                        );
                        v++;
                        tweetVid = document.getElementById('twitter-vid-widget-' + v);
                    }
                });
            }
        });


}());
