var zipCode = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    // prefetch: '../data/films/post_1960.json',
    remote: {
        url: getTagsUrl+'/%QUERY',
        wildcard: '%QUERY'
    }
});


$('#hero-demo').typeahead(
    {
        hint: true,
        minLength:3,
        highlight: true,

    }, {
        // limit: 5,
        limit: Infinity,
        name: 'best-pictures',
        display: 'value',
        source: zipCode,
        templates: {
            empty: [
                '<div class="empty-message">',
                'unable to find your ZipCode',
                '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile('<div><strong>{{ value }}</strong></div>')
        }
    }).on('typeahead:asyncrequest', function() {

//    $("#zip_codeVal").val('');
    $('.Typeahead-spinner').css('display','block');

}).on('typeahead:asynccancel typeahead:asyncreceive', function() {

    $('.Typeahead-spinner').css('display','none');

});
