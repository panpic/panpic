$(document).ready (function()
{
    var editor = CKEDITOR.replace('full_content_vi');
    CKFinder.setupCKEditor(editor, '/ckfinder/');

    CKEDITOR.on('dialogDefinition', function(ev) {
        // Take the dialog name and its definition from the event data
        var dialogName = ev.data.name;
        var dialogDefinition = ev.data.definition;
        var editor = ev.editor;

        // console.log(ev);

        if (dialogName == 'image') {

            dialogDefinition.onOk = function(e) {
                var imageSrcUrl = e.sender.originalElement.$.src;

                // console.log(e);
                // console.log(imageSrcUrl);
                // console.log(base_url_admin+"/webp");

                const array = imageSrcUrl.split('/');
                // console.log(array.length);
                // console.log(array[array.length-1]);
                var image_name = array[array.length-1];
                const array_image_name = image_name.split('.');
                var image_name_ext = array_image_name[array_image_name.length-1];
                // console.log('Ext: '+image_name_ext);

                if(image_name_ext != 'webp') {
                    // console.log('Hinh gi: '+imageSrcUrl);

                    //goi ajax resize luon
                    const xhttp = new XMLHttpRequest();
                    xhttp.open("POST", base_url_admin+"/webp");
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("UrlHinh="+imageSrcUrl);
                    xhttp.onreadystatechange = function() {
                        console.log(xhttp.readyState);

                        if (xhttp.readyState === 4) {
                            // var response = JSON.parse(xhttp.responseText);
                            if (xhttp.status === 200) {
                                // console.log('successful');
                                // console.log( xhttp.responseText );
                                var path_file_webp = xhttp.responseText;
                                console.log('convert: '+path_file_webp);

                                xhttp.onload = function(){
                                    // location.reload();
                                    // imageSrcUrl = imageSrcUrl.replace("/images/", "/webp/");
                                    var hkt_html = '<img src="'+path_file_webp+'" alt="" style="width:750px">';
                                    var imgHtml = CKEDITOR.dom.element.createFromHtml(hkt_html);
                                    editor.insertElement(imgHtml);
                                }
                            } else {
                                // console.log('failed');

                                var hkt_html = '<img src="'+imageSrcUrl+'" alt="" style="width:750px">';
                                var imgHtml = CKEDITOR.dom.element.createFromHtml(hkt_html);
                                editor.insertElement(imgHtml);

                            }
                        }
                    }

                } else {
                    var hkt_html = '<img src="'+imageSrcUrl+'" alt="" style="width:750px">';
                    var imgHtml = CKEDITOR.dom.element.createFromHtml(hkt_html);
                    editor.insertElement(imgHtml);
                }

            };
        }
    });

});

