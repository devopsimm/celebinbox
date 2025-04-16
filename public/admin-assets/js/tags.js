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
