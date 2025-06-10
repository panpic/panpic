var lastResults = [];

$("#tags").select2({
    multiple: true,
    placeholder: "Please enter tags",
    tokenSeparators: [","],

    initSelection: function(element, callback) {
        var data = [];
        $(element.val().split(",")).each(function() {
            data.push({
                id: this,
                text: this
            });
        });
        callback(data);
    },

    ajax: {
        multiple: true,
        url: base_url_admin+"/blogs/ajx_tags/",
        dataType: "json",
        type: "POST",
        async : false,
        data: function(term) {
            return {q: term};
        },
        results: function(data) {
            return {results: data};
        },
    },
    data: [{id: 'tag', text: 'tag'}],

    createSearchChoice: function(term) {
        var text = term + (lastResults.some(function(r) {
            return r.text == term
        }) ? "" : ""); // (new)
        return {
            id: term,
            text: text
        };
    },

});

$('#tags').on("change", function(e) {
    if (e.added) {
        if (/ \(new\)$/.test(e.added.text)) {
            var response = true; // confirm("Add new tag " + e.added.id + "?");

            if (response == true) {

                // alert("Will now send new tag to server: " + e.added.id);

                /*
               $.ajax({
                   type: "POST",
                   url: '/someurl&action=addTag',
                   data: {id: e.added.id, action: add},
                   error: function () {
                      alert("error");
                   }
                });
               */
            } else {
                console.log("Removing the tag");
                var selectedTags = $("#tags").select2("val");
                var index = selectedTags.indexOf(e.added.id);
                selectedTags.splice(index, 1);
                if (selectedTags.length == 0) {
                    $("#tags").select2("val", "");
                } else {
                    $("#tags").select2("val", selectedTags);
                }
            }
        }
    }
});