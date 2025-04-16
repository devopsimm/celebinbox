$("#fieldType").change(function (){
    var type = $("#fieldType").val();
    optionsFeilds = 0;
    if (type != 'select' && type != 'multiselect' && type != 'radio'){
        optionsFeilds = 0;
    }else{
        optionsFeilds = 1;
    }
    if (optionsFeilds == 1){
        $("#options").css('display','block');
        $("#options input").prop('required',true);
    }else{
        $("#options").css('display','none');
        $("#options input").prop('required',false);
    }
});
$(".addMore").click(function () {
    var html = $("#tableContent").html();
    $(".added").append(html);
    $("#options input").prop('required',true);
});
function removeOpt(t) {
    ele = $(t);
    ele.closest('.row').remove();
}
$("#productType").change(function (){
    let val = $(this).val();
    getProductSpecificationCat(val,'0');
});
function getProductSpecificationCat(typeId,preId) {
    let val = typeId;
    let selectBox = $("#specification_category_id");
    selectBox.html('');
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
        url: getCategoriesSpecificationByTypeRoute,
        method: 'POST',
        data: {
            typeId:val,
        },
        success: function (res) {
            if(res == '404'){

            }else{
                let categories = JSON.parse(res);
                let html = '';
                $.each(categories,function (key,val){
                    let selected = (key == preId) ? 'selected' : '';
                    html += '<option '+ selected +' value="'+key+'">'+val.value+'</option>';
                });
                selectBox.html(html);
            }
            $.unblockUI();
        }
    });

}
