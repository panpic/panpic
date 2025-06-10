function process_img() {

    $(".dz-preview").each(function () {
        var test = $(this).find('.dz-details').html();
		 
        var file_url = $(this).find('img').get(0).src;
        var file_name = $(this).find('img').get(0).alt
        var str_a = '<a href="' + file_url + '" target="_blank">' + test + '</a>';

        $(this).find('.dz-size').css('display', 'none');
        $(this).find('.dz-details').html(str_a);
        var main = getMain(file_name);
        var num_check = $(this).find('.check_main').length;

        if (num_check == 0) {
            if (main == 1) {
                $('<div class=""><label><input product_id="' + product_id + '" class="check_main" name="check_main" type="radio" value="' + file_name + '" checked="checked" /> Main image</label</div>').insertBefore($(this).find('.dz-remove'));
            } else {
                $('<div class=""><label><input product_id="' + product_id + '" class="check_main" name="check_main" type="radio" value="' + file_name + '" /> Main image</label></div>').insertBefore($(this).find('.dz-remove'));
            }
        }
        //$( "#check_main" ).trigger( "click" );
        /*        
         if (main == 1) {
         $('<div class=""><input class="check_main" name="check_main" type="radio" value="' + file_name + '" checked="checked" /> Main image</div>').insertBefore($(this).find('.dz-remove'));
         } else {
         $('<div class=""><input class="check_main" name="check_main" type="radio" value="' + file_name + '" /> Main image</div>').insertBefore($(this).find('.dz-remove'));
         }
         */
    });

}


function checkMain() {

    $('.check_main').on('change keyup click', function () {
        var file_main = $(this).val();
        var product_id = $('input:radio[name=check_main]:checked').attr('product_id');
        //alert(product_id);

        var term = $('input:radio[name=check_main]:checked').val();
        var type = (term) ? 1 : 0;

        if (file_main) {

            $.ajax({
                type: "POST",
                url: base_url_admin + "myfile/mainfile/",
                async: false,
                data: "file_main=" + file_main + "&type=" + type + "&product_id=" + product_id,
                success: function (text) {
                },
            });
        }
    });

}



function getMain(file_name) {

    var flag = 0;

    if (file_name) {

        $.ajax({
            type: "POST",
            url: base_url_admin + "myfile/maincheck/",
            async: false,
            data: "file_main=" + file_name,
            success: function (text) {

                if (text == 1) {
                    flag = 1;
                }

            },
        });
    }

    return flag;
}



(function ($)
{
    if (typeof Dropzone != 'undefined')
        Dropzone.autoDiscover = false;

    if ($.fn.dropzone != 'undefined')
        $('.dropzone').dropzone({
            init: function () { // view
                thisDropzone = this;
                $.ajax({
                    type: 'GET',
                    url: control_file_view,
                    data: "",
                    dataType: 'json',
                    success: function (data) {

                        $.each(data, function (key, value) {

                            var mockFile = {name: value.name, size: value.size, paramName: value.url};

                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);

                        });
                        //$( "#check_main" ).trigger( "click" );
                    }
                });


                this.on("success", function (file) {

                    $("div").remove(".dz-preview ");

                    thisDropzone = this;
                    $.ajax({
                        type: 'GET',
                        url: control_file_view,
                        data: "",
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (key, value) {

                                var mockFile = {name: value.name, size: value.size, paramName: value.url};

                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);

                                //mylittlefix(data);

                            });

                            $( "#check_main" ).trigger( "click" );
                        }
                    });

                });



                this.on("complete", function (file) {

                    var timeoutID = window.setTimeout(process_img, 1000);

                });

            },
            clickable: true,
            addRemoveLinks: 'yes',
            removedfile: function (file) { // delete
                var name = file.name;
                $.ajax({
                    type: 'POST',
                    url: control_file_delete,
                    data: "files=" + name,
                    dataType: 'html',
                    success: function (data) {
                        //
                    }
                });

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            dictRemoveFile: 'Remove',
        });


})(jQuery);



