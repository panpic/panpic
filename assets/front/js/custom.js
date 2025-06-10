let bj = {};
!(function (e) {
    "use strict";
    let i = e(window),
        t = e("body"),
        s = (e("html"), e(document));
    (e.fn.exists = function () {
        return this.length > 0;
    }),
        (e.fn.isMobile = function () {
            return !(i.width() > 768);
        }),
        (e.fn.isMobileAndTablet = function () {
            return !(i.width() > 991);
        }),
        (bj.uaSetting = function () {
            let e = {
                Tablet:
                    (-1 !== (i = window.navigator.userAgent.toLowerCase()).indexOf("windows") && -1 !== i.indexOf("touch") && -1 === i.indexOf("tablet pc")) ||
                    -1 !== i.indexOf("ipad") ||
                    (-1 !== i.indexOf("android") && -1 === i.indexOf("mobile")) ||
                    (-1 !== i.indexOf("firefox") && -1 !== i.indexOf("tablet")) ||
                    -1 !== i.indexOf("kindle") ||
                    -1 !== i.indexOf("silk") ||
                    -1 !== i.indexOf("playbook"),
                Mobile:
                    (-1 !== i.indexOf("windows") && -1 !== i.indexOf("phone")) ||
                    -1 !== i.indexOf("iphone") ||
                    -1 !== i.indexOf("ipod") ||
                    (-1 !== i.indexOf("android") && -1 !== i.indexOf("mobile")) ||
                    (-1 !== i.indexOf("firefox") && -1 !== i.indexOf("mobile")) ||
                    -1 !== i.indexOf("blackberry"),
            };
            var i;
            (e.Mobile || e.Tablet) && t.addClass("sp");
        }),
        (bj.initLoading = function () {
            let i = e(".loader");
            i.exists() && i.fadeOut(400), t.removeClass("hidden");
        }),
        (bj.toggleSearchForm = function () {
            let i = e(".search-form__jws"),
                t = e(".search-form-trigger"),
                s = e(".search-form__overlay"),
                n = e(".search-form__close");
            function o(e) {
                "close" === e
                    ? (i.removeClass("is-visible"), t.removeClass("search-is-visible"))
                    : (i.toggleClass("is-visible"),
                        t.toggleClass("search-is-visible"),
                    i.hasClass("is-visible") && i.find('input[type="text"]').focus(),
                        i.hasClass("is-visible") ? s.addClass("is-visible removeicon") : s.removeClass("is-visible removeicon"));
            }
            t.on("click", function (e) {
                e.preventDefault(), o();
            }),
                n.on("click", function (e) {
                    e.preventDefault(), o(close);
                });
        }),
        i.on("load", function () {
            bj.initLoading();
        }),
        s.ready(function () {
            bj.uaSetting(),
                bj.toggleSearchForm();
        });
})(jQuery);

jQuery(document).ready(function(){

    $('.btnSubscriber').click(function() { $("#frm-subscriber").submit(); });

    $("#frm-sub").submit(function(e) {
        let s_e = $('#sub_e').val(), s_fn = $('#sub_fn').val(), s_p = $('#sub_p').val();
        if( s_e != '' && s_fn != '' && s_p != '' ) {
            var md = $('#modal-notification');
            var frm = $('#frm-subscriber');
            $.ajax( {
                type: "POST",
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function( d ) {
                    var bj = jQuery.parseJSON(d), res = bj.status, s_s = bj.content;
                    if(res == 1) {
                        $('#modal-notification').html(s_s);
                        md.show();
                        $('.close').click(function () { md.hide(); });
                        $(window).on('click', function (e) { if ($(e.target).is('.modal')) { md.hide();} });
                    }
                }
            });
        }

        e.preventDefault();
    });

    window.setTimeout(function(){$(".alert").fadeTo(700, 0).slideUp(700, function(){$(this).remove();});}, 4000);

});