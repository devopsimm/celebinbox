$(".postBtn").click(function (){
    let ele = $(this);
    ele.toggleClass('clicked');
    let target = $("."+ele.attr('data-targetClass'));
    target.toggleClass('displayNone');
    if(target.find('input').prop('required') == false || target.find('input').prop('required') == 'undefined'){
        target.find('input').prop('required',true); //.css('background','#333');
    }else{
        target.find('input').prop('required',false);
    }

});



// Tags
var cache = {};
function tagSuggests(request, response) {
    var term = request.term;
    if (term in cache) { response(cache[term]); return; }
    $.ajax({
        url: getTagsUrl+'/'+term,
        data: { tag:term },
        success: function(res) {

            var suggestions = [];
            let results = JSON.parse(res);

            $.each(results, function(tag,val) {
                try {
                    var s = val.toLowerCase();
                    suggestions.push({label: s.replace(term, term), value: s});
                } catch(e){}
            });
            cache[term] = suggestions;
            response(suggestions);
        }
    });
}

$('#hero-demo').tagEditor({
    autocomplete: { source: tagSuggests, minLength: 3, delay: 250, html: true, position: { collision: 'flip' } },
    delimiter: ', ',
    placeholder: 'Enter tags ...'
}).css('display', 'block').attr('readonly', true);

// Category
$("#parent_category").change(function (){
    let ele = $(this);
    let val = ele.val();
    getChildCategories(val)
});
$(document).ready(function (){

    let categoryID = $("#ParentCategoryId").val();
    if(categoryID !== ''){
        getChildCategories(categoryID);
    }
    let sourceType = $("#sourceType").val();
    getAuthors(sourceType);
});

// Save Post
$("#savePost").click(function (){
    addCaptionsToImages();
    let descriptionEle = $(".editable");

    let desData = manageDescriptionData(descriptionEle);

    // let description = $('<div>').append(desData.clone()).html();
    let description = desData.html();
    $("#description").val(description);


    if (validation() !== false){
        document.getElementById("postForm").submit();
    }
    // $("#postForm").submit();
});
let relatedPostsPopup = $(".relatedPostsPopup");

relatedPostsPopup.hide();
$("#searchRelatedPost").click(function (){
    let postId = $("#post_edit_id").val();
    let htmlHolder = $(".relatedPostsPopup .holder");
    let relatedPosts = $("#relatedPosts");
    let val = relatedPosts.val();
    if(val !== ''){
        let ele = $(this);
        ele.prop('disabled',true);
        relatedPosts.prop('disabled',true);
        $.ajax({
            url: getRelatedPosts,
            method: 'POST',
            data: {
                search:val,
                postId:postId,
            },
            success: function (res) {
                if(res == '404'){

                }else{
                    let lists = JSON.parse(res);
                    let html = '<ul>';
                    $.each(lists,function (key,val){
                        html += '<li data-key="'+key+'" data-value="'+val+'" onclick="addRelatedPost(this)" >';
                        html += '<b>'+val+'</b>';
                        html += '</li>';
                    });
                    html += '</ul>';
                    htmlHolder.html(html);
                    relatedPostsPopup.show();

                }
                // $.unblockUI();
            },
            complete: function (){
                ele.prop('disabled',false);
                relatedPosts.prop('disabled',false);
            }
        });

    }


});

$(".relatedPostsPopup .PopUpClose").click(function (){
    relatedPostsPopup.hide();
});

$("#image-container").click(function (){
    $("#image-upload").trigger('click');
})

$("#image-upload").on("change",function(){
    $("span.imgContainerText").hide();
    var $input = $(this);
    var reader = new FileReader();
    reader.onload = function(){
        $("#imagePreview").attr("src", reader.result);
    }
    reader.readAsDataURL($input[0].files[0]);
});

function manageDescriptionData(descriptionEle) {
    var desData = $(descriptionEle);
    desData.find('div.medium-insert-buttons').remove();
    desData.find('div.medium-insert-embed.tweetVideo').each(function (j, k) {
        if (typeof $(this).find('div').attr("class") == "undefined") {
            $(this).addClass('removeAbleDiv');
        }
    });
    desData.find('.tweetPost').each(function (j, k) {
        if ($(this).find('.twitter-tweet').length == '0') {
            $(this).addClass('removeAbleDiv');
        }
    });
    desData.find(".removeAbleDiv").remove();
    return desData;
}

function addCaptionsToImages(){
    //Add figure detail main image alt
    $('.medium-insert-images > figure').each(function (k,v){
        var figure = $(v).children('img');
        if($(v).children('figcaption').length > 0){
            var caption = $.trim($(v).children('figcaption').text().replace(/['"]+/g, ''))
            $(figure).attr('alt',caption)
        }else{
            var heading =  $.trim($('#title').val().replace(/['"]+/g, ''));
            $(figure).attr('alt',heading)
        }
    });

}

// Related Posts
function addRelatedPost(th){
    let ele = $(th);
    let key = ele.attr('data-key');
    let value = ele.attr('data-value');
    let html = '<div class="relatedPost">';
    html += '<input type="hidden" name="relatedPostIds[]" value="'+key+'" />';
    html += '<span class="removeRelatedPost" onclick="removeRelatedPost(this)">-</span>';
    html += '<b>'+value+'</b>';
    html += '</div>';
    $("#relatedPostsHolder").append(html);
}

function removeRelatedPost(th){
    let ele = $(th);
    ele.parent().remove();
}

function validation(){

    let validated = true;

    $("input").each(function (index){
        let ele = $(this);
        if(ele.attr('required')){
            if(ele.attr('type') != 'file'){
                if (ele.val() == ''){
                    validated = false;
                    ele.addClass('error');
                }else{
                    ele.removeClass('error');
                }
            }

        }
    });

    $("textarea").each(function (index){
        let ele = $(this);
        if(ele.attr('required')){
            if (ele.val() == ''){
                validated = false;
                ele.addClass('error');
            }else{
                ele.removeClass('error');
            }
        }
    });

    $("select").each(function (index){
        let ele = $(this);
        if(ele.attr('required')){
            ele.parent().find('span.error').remove();
            if (ele.val() == null){
                validated = false;
                ele.after('<span class="error">is required</span>');
            }else{
            }
        }
    });

    return validated;
}

function has_attr(attr) {
    if (typeof attr !== typeof undefined && attr !== false) {
        return true;
    } else {
        return false;
    }
}

$("#sourceType").change(function (){
    let sourceType = $(this).val();
    getAuthors(sourceType);
});

function getAuthors(sourceType){
    let selectBox = $("#authors");
    let postId = $("#post_edit_id").val();
    $.ajax({
        url: getAuthorsBySourceType,
        method: 'POST',
        data: {
            sourceType:sourceType,
            postId:postId
        },
        success: function (res) {
            console.log(res);
            let html = '';
            $.each(res,function (key,val){
                let isSelected = (val.selected == "yes")?"selected":"";
                html += '<option '+isSelected+' value="'+key+'">'+val.value+'</option>';
            });
            selectBox.html(html);
        }
    });
}
function getChildCategories(val){
    let selectBox = $("#categories");
    let postId = $("#post_edit_id").val();

    $.ajax({
        url: getChildCategoriesRoute,
        method: 'POST',
        data: {
            categoryId:val,
            postId:postId,
        },
        success: function (res) {
            if(res == '404'){

            }else{
                let categories = JSON.parse(res);
                let html = '';
                $.each(categories,function (key,val){
                    let selected = (val.selected == 'yes') ? 'selected' : '';
                    html += '<option '+ selected +' value="'+val.id+'">'+val.name+'</option>';
                });
                selectBox.html(html);
                selectBox.select2();
            }
        }
    });
}
