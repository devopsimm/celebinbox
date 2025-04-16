$.validator.setDefaults({ ignore: '' });

$(document).ready(function () {
    // jQuery.validator.addMethod("lettersonly", function (value, element) {
    //     // return this.optional(element) || /^[a-z][a-z\s]*$/i.test(value);
    //     return this.optional(element) || /^[ZÃ€aA-Ã¿zZ\s]*$/i.test(value);
    // }, "Letters only please");
    //
    // jQuery.validator.addMethod("emailExt", function (value, element, param) {
    //     return value.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    // }, 'Your E-mail is wrong');

    $('.validate').validate({

        lang: window._locale || 'en', // en as fallback
        submitHandler: function (form) {
            $("input[type=submit]").attr("disabled", true);
            $("button[type=submit]").attr("disabled", true);
            $(form)[0].submit();
        }
    });

    $('.validate').find('select').each(function () {
        var attr = $(this).attr('required');
        if (has_attr(attr)) {
            $(this).rules("add", {
                required: true,
            });
        }
    });

    $('.validate').find('input').each(function () {

        var attr = $(this).attr('number');
        if (has_attr(attr)) {

            $('input[name=' + $(this).attr('name') + ']').rules("add", {
                number: true
            });

        }


        if ($(this).attr('type') == 'email') {

            $('input[name=' + $(this).attr('name') + ']').rules("add", {
                email: false,
                required: true,
                emailExt: true,

            });

        }
        //your code here
        var attr = $(this).attr('lettersonly');

        // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
        if (has_attr(attr)) {

            // Element has this attribute
            $('input[name=' + $(this).attr('name') + ']').rules("add", {
                lettersonly: true
            });
        }
        var attr = $(this).attr('equal_to');
        if (has_attr(attr)) {

            $('input[name=' + $(this).attr('name') + ']').rules("add", {
                equalTo: '#' + $(this).attr('equal_to')
            });

        }
    });

});

function has_attr(attr) {
    if (typeof attr !== typeof undefined && attr !== false) {
        return true;
    } else {
        return false;
    }
}
