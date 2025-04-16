let addBtn = $("#addSpecification");
let specificationCategoryId =  $("#specification_category_id");
let specificationHolder =  $("#specificationHolder");
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
$("#image-container").click(function (){
    $("#image-upload").trigger('click');
});
$(document).ready(function(){


    $("#image-upload").on("change",function(){
        $("span.imgContainerText").hide();
        // var $input = $(this);
        // var reader = new FileReader();
        // reader.onload = function(){
        //     $("#imagePreview").attr("src", reader.result);
        // }
        // reader.readAsDataURL($input[0].files[0]);

        $("#image-container").empty(); // Clear previous previews

        var $input = $(this);
        var files = $input[0].files;

        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = (function (file) {
                return function (e) {
                    var preview = $('<img/>', {
                        class: 'image-preview',
                        src: e.target.result,
                        title: file.name
                    });
                    $("#image-container").append(preview);
                };
            })(files[i]);
            reader.readAsDataURL(files[i]);
        }
    });
    $("#productType").change(function (){
        let val = $(this).val();
        getProductSpecificationCat(val,'0');
        specificationHolder.html('');
    });
    specificationCategoryId.change(function (){
        addBtn.prop('disabled',false);
    });
    addBtn.click(function (){
        let val = specificationCategoryId.select2("val");
        $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            } });
        $.ajax({
            url: getSpecificationByCatRoute,
            method: 'POST',
            data: {
                specificationCategoryId:val,
            },
            success: function (res) {
                if(res == '404'){

                }else{
                    specificationHolder.append(res);
                    specificationCategoryId.find('option[value='+val+']').attr('disabled', 'disabled');
                    specificationCategoryId.select2();
                }
                $.unblockUI();
            }
        });

    });
    pageLoad();
});
async function pageLoad(){
    if(product !== false && product !== ''){
        $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            } });
        let productTypeId = $("#productType").val();
        await getProductSpecificationCat(productTypeId,product,false);
        await getProductSpecification(product);
        $.unblockUI();
    }

}
function getProductSpecificationCat(typeId,preId,blockScreen=true) {
    let val = typeId;
    let selectBox = specificationCategoryId;
    selectBox.html('');
    if(blockScreen){
        $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            } });
    }
    $.ajax({
        url: getCategoriesSpecificationByTypeRoute,
        method: 'POST',
        data: {
            typeId:val,
            productId:preId
        },
        success: function (res) {
            if(res == '404'){

            }else{
                let categories = JSON.parse(res);
                let html = '<option disabled selected>Select Specification Category</option>';
                $.each(categories,function (key,val){
                    let selected = (val.selected == 'yes') ? 'selected disabled' : '';
                    html += '<option '+ selected +' value="'+key+'">'+val.value+'</option>';
                });
                selectBox.html(html);
                addBtn.prop('disabled',true);
            }
            if(blockScreen) {
                $.unblockUI();
            }
        }
    });

}
function getProductSpecification(product){
    $.ajax({
        url: getSpecificationByProductRoute,
        method: 'POST',
        data: {
            product:product,
        },
        success: function (res) {
            if(res == '404'){

            }else{
                specificationHolder.append(res);

            }

        }
    });
}
