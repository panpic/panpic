$(document).ready(function() {

    $('img[usemap]').rwdImageMaps();

    var modal = $('#modal-keystaff');
    $(".modal .close").on("click",function(){ modal.hide();});

    $('#k1').click(function(){
        var _title = $('#k1_content h4').text();
        var _content = $('#k1_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k2').click(function(){
        var _title = $('#k2_content h4').text();
        var _content = $('#k2_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k3').click(function(){
        var _title = $('#k3_content h4').text();
        var _content = $('#k3_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k4').click(function(){
        var _title = $('#k4_content h4').text();
        var _content = $('#k4_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k5').click(function(){
        var _title = $('#k5_content h4').text();
        var _content = $('#k5_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k6').click(function(){
        var _title = $('#k6_content h4').text();
        var _content = $('#k6_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k7').click(function(){
        var _title = $('#k7_content h4').text();
        var _content = $('#k7_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k8').click(function(){
        var _title = $('#k8_content h4').text();
        var _content = $('#k8_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    $('#k9').click(function(){
        var _title = $('#k9_content h4').text();
        var _content = $('#k9_content p').html();
        $('#title-keystaff').html(_title);
        $('#content-keystaff').html(_content);
        modal.show();
    });

    if ( $(window).width() > 700){

        /* set the image-map width and height to match the img size */
        $('#image-map').css({'width':$('#image-map img').width(),
            'height':$('#image-map img').height()
        });

        /*tooltip direction*/
        var tooltipDirection;

        for (i = 0; i < $(".pin").length; i++) {
            /* set tooltip direction type - up or down */
            if ($(".pin").eq(i).hasClass('pin-down')) {
                tooltipDirection = 'tooltip-down';
            } else {
                tooltipDirection = 'tooltip-up';
            }

            /* append the tooltip */
            $("#image-map").append("<div style='left:" + $(".pin").eq(i).data('xpos') + "px;top:" + $(".pin").eq(i).data('ypos') + "px' class='" + tooltipDirection + "'>\
									<div class='tooltip2'>" + $(".pin").eq(i).html() + "</div>\
									</div>");
        }

        /* show/hide the tooltip */
        $('.tooltip-up, .tooltip-down').mouseenter(function () {
            $(this).children('.tooltip2').fadeIn(100);
        }).mouseleave(function () {
            $(this).children('.tooltip2').fadeOut(100);
        });
    }
});