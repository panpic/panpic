/*-----------------------------------------------------------------------------------*/
/*	CUSTOM FUNCTIONS
/*-----------------------------------------------------------------------------------*/
function scrollHoverGallery(gallery){
	var nextActiveSlide = jQuery(gallery).find('li.active').next();

	if (nextActiveSlide.length === 0) {
		nextActiveSlide = jQuery(gallery).find('li:first-child');
	}

	jQuery(gallery).find('li.active').removeClass('active');
	nextActiveSlide.addClass('active');
}
function parallaxBackground(){
	jQuery('.parallax').each(function(){
		var element = jQuery(this).closest('section'),
			scrollTop = jQuery(window).scrollTop(),
	    	scrollBottom = scrollTop + jQuery(window).height(),
	    	elemTop = element.offset().top,
	    	elemBottom = elemTop + element.outerHeight();

		if((scrollBottom > elemTop) && (scrollTop < elemBottom)){
			var value = ((scrollBottom - elemTop)/5);
			jQuery(element).find('.parallax').css({
                transform: 'translateY(' + value + 'px)'
            });
		}
	});	
}
function mr_parallax(){function a(a){for(var b=0;b<a.length;b++)if("undefined"!=typeof document.body.style[a[b]])return a[b];return null}function b(){E=void 0==window.mr_variant?!1:!0,E&&(C=jQuery(".viu").get(0),void 0!=C&&(C.scrollBy=function(a,b){this.scrollTop+=b})),void 0!=C&&(C.addEventListener("scroll",h,!1),window.addWheelListener(C,i,!1),window.addEventListener("resize",function(){n=Math.max(document.documentElement.clientHeight,window.innerHeight||0),o=c(),D.profileParallaxElements()},!1),e())}function c(){var a=0;return void 0!=C&&(a=jQuery(C).find("nav:first").outerHeight(!0)),a}function d(a,b,c,d){var e=a-1;return e/=d,a/=d,e--,a--,c*(a*a*a*a*a+1)+b-(c*(e*e*e*e*e+1)+b)}function e(){if(p){for(var a=j.length,b=g();a--;)f(j[a],b);p=!1}q&&(w+=-t*d(s,0,z,B),(w>A||-A>w)&&(C.scrollBy(0,w),w=0),s++,s>B&&(s=0,q=!1,r=!0,t=0,u=0,v=0,w=0)),k(e)}function f(a,b){if(E){if(b+n>a.elemTop&&b<a.elemBottom)if(a.isFirstSection){var c="translate3d(0, "+b/2+"px, 0)";a.imageHolder.style[m]=c}else{var c="translate3d(0, "+(b-a.elemTop-o)/2+"px, 0)";a.imageHolder.style[m]=c}}else if(b+n>a.elemTop&&b<a.elemBottom)if(a.isFirstSection){var c="translate3d(0, "+b/2+"px, 0)";a.imageHolder.style[m]=c}else{var c="translate3d(0, "+(b+n-a.elemTop)/2+"px, 0)";a.imageHolder.style[m]=c}}function g(){return C!=window?C.scrollTop:0==document.documentElement.scrollTop?document.body.scrollTop:document.documentElement.scrollTop}function h(){p=!0}function i(a){a.preventDefault&&a.preventDefault(),t=a.notRealWheel?-a.deltaY/4:1==a.deltaMode?-a.deltaY/3:100===Math.abs(a.deltaY)?-a.deltaY/120:-a.deltaY/40,t=-x>t?-x:t,t=t>x?x:t,q=!0,s=y}var j,k=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame,l=["transform","msTransform","webkitTransform","mozTransform","oTransform"],m=a(l),n=Math.max(document.documentElement.clientHeight,window.innerHeight||0),o=0,p=!1,q=!1,r=!0,s=0,t=0,u=0,v=0,w=0,x=2,y=4,z=300,A=1,B=30,w=0,C=window,D=this,E=void 0==window.mr_variant?!1:!0;jQuery(document).ready(function(){"use strict";n=Math.max(document.documentElement.clientHeight,window.innerHeight||0),/Android|iPad|iPhone|iPod|BlackBerry|Windows Phone/i.test(navigator.userAgent||navigator.vendor||window.opera)?jQuery(".parallax").removeClass("parallax"):k&&(window.mr_parallax.profileParallaxElements(),b())}),jQuery(window).load(function(){n=Math.max(document.documentElement.clientHeight,window.innerHeight||0),o=c(),window.mr_parallax.profileParallaxElements()}),this.profileParallaxElements=function(){j=[],o=c(),selector=".parallax > .background-image-holder, .parallax ul.slides > li > .background-image-holder",E&&(selector=".viu .parallax > .background-image-holder, .viu .parallax ul.slides > li > .background-image-holder"),jQuery(selector).each(function(a){var b=jQuery(this).closest(".parallax"),c=E?b.position().top:b.offset().top;j.push({section:b.get(0),outerHeight:b.outerHeight(),elemTop:c,elemBottom:c+b.outerHeight(),isFirstSection:b.is(":first-of-type")?!0:!1,imageHolder:jQuery(this).get(0)}),E?E&&(b.is(":first-of-type")?D.mr_setTranslate3DTransform(jQuery(this).get(0),0==g()?0:g()/2):D.mr_setTranslate3DTransform(jQuery(this).get(0),(g()-c-o)/2)):b.is(":first-of-type")?D.mr_setTranslate3DTransform(jQuery(this).get(0),0==g()?0:g()/2):D.mr_setTranslate3DTransform(jQuery(this).get(0),(g()+n-c-o)/2)})},this.mr_setTranslate3DTransform=function(a,b){a.style[m]="translate3d(0, "+b+"px, 0)"}}window.mr_parallax=new mr_parallax,function(a,b){function c(b,c,g,h){b[d](f+c,"wheel"==e?g:function(b){!b&&(b=a.event);var c={originalEvent:b,target:b.target||b.srcElement,type:"wheel",deltaMode:"MozMousePixelScroll"==b.type?0:1,deltaX:0,deltaZ:0,notRealWheel:1,preventDefault:function(){b.preventDefault?b.preventDefault():b.returnValue=!1}};return"mousewheel"==e?(c.deltaY=-1/40*b.wheelDelta,b.wheelDeltaX&&(c.deltaX=-1/40*b.wheelDeltaX)):c.deltaY=b.detail/3,g(c)},h||!1)}var d,e,f="";a.addEventListener?d="addEventListener":(d="attachEvent",f="on"),e="onwheel"in b.createElement("div")?"wheel":void 0!==b.onmousewheel?"mousewheel":"DOMMouseScroll",a.addWheelListener=function(a,b,d){c(a,e,b,d),"DOMMouseScroll"==e&&c(a,"MozMousePixelScroll",b,d)}}(window,document);
/*-----------------------------------------------------------------------------------*/
/*	DOCUMENT READY FUNCTIONS
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function() { 
	"use strict";
	
	jQuery('p:empty').remove();
	jQuery(".embed-video-container").fitVids();
	jQuery('.more-link').wrap('<div class="text-center" />');
	jQuery('.woocommerce .button').removeClass('button').addClass('text-link');

	// Variables
	var triggerVid,
		launchkit_hoverGallery,
		navHeight = jQuery('.nav-container').height();
		
	if( jQuery('body').hasClass('admin-bar') ){
		navHeight = (navHeight + 32);
	}

    // Smooth scroll to inner links
	jQuery('a[href^="#"]').not('a[href="#"]').smoothScroll({
		offset: -navHeight,
		speed: 800
	});

    // Sticky nav
    if (!jQuery('nav').hasClass('overlay')) {
        jQuery('.nav-container').css('min-height', jQuery('nav').outerHeight()).css('height', jQuery('nav').outerHeight());
    }
    
    // Set bg of nav container if dark skin
    if(jQuery('nav').hasClass('dark')){
    	jQuery('.nav-container').addClass('dark');
    }
    
	if(!jQuery('nav').hasClass('fixed') && !jQuery('nav').hasClass('overlay')){
	       
	    // Compensate the height of parallax element for inline nav
	    if(jQuery(window).width() > 768){
	        jQuery('.parallax:first-child .background-image-holder').css('top', -(jQuery('nav').outerHeight(true)));
	    }
	    
	    // Adjust fullscreen elements
	    if(jQuery(window).width() > 768 && (jQuery('section.parallax:first-child, header.parallax:first-child').outerHeight() == jQuery(window).height()) ){
	        jQuery('section.parallax:first-child, header.parallax:first-child').css('height', (jQuery(window).height() - jQuery('nav').outerHeight(true)));
	    }
	}

    // Mobile nav
    jQuery('.mobile-toggle').click(function() {
        jQuery(this).closest('nav').toggleClass('nav-open');
        if (jQuery(this).closest('nav').hasClass('nav-3')) {
            jQuery(this).toggleClass('active');
        }
    });

    // Fixed header scrolling for desktop browsers
	parallaxBackground();
	jQuery(window).scroll(function(){
		requestAnimationFrame(parallaxBackground);
        jQuery('.contact-2 .map-holder').addClass('screen');
	});

    // Initialize sliders
    jQuery('.hero-slider').flexslider({
        directionNav: false
    });
    jQuery('.slider').flexslider({
        directionNav: false
    });

    // Append .background-image-holder <img>'s as CSS backgrounds
    jQuery('.background-image-holder').each(function() {
        var imgSrc = jQuery(this).children('img').attr('src');
        jQuery(this).css('background', 'url("' + imgSrc + '")');
        jQuery(this).children('img').hide();
        jQuery(this).css('background-position', '50% 50%');
    });
    
    // Fade in background images
	setTimeout(function(){
		jQuery('.background-image-holder').each(function() {
			jQuery(this).addClass('fadeIn');
		});
    },200);


    // Hook up video controls on local video
    jQuery('.local-video-container .play-button').click(function() {
        jQuery(this).toggleClass('video-playing');
        jQuery(this).closest('.local-video-container').find('.background-image-holder').toggleClass('fadeout');
        var video = jQuery(this).closest('.local-video-container').find('video');
        if (video.get(0).paused === true) {
            video.get(0).play();
        } else {
            video.get(0).pause();
        }
    });

    jQuery('video').bind("pause", function() {
        var that = this;
        triggerVid = setTimeout(function() {
            jQuery(that).closest('section').find('.play-button').toggleClass('video-playing');
            jQuery(that).closest('.local-video-container').find('.background-image-holder').toggleClass('fadeout');
            jQuery(that).closest('.modal-video-container').find('.modal-video').toggleClass('reveal-modal');
        }, 100);
    });

    jQuery('video').on('play', function() {
        if (typeof triggerVid === 'number') {
            clearTimeout(triggerVid);
        }
    });

    jQuery('video').on('seeking', function() {
        if (typeof triggerVid === 'number') {
            clearTimeout(triggerVid);
        }
    });

    // Video controls for modals
    jQuery('.modal-video-container .play-button').click(function() {
        jQuery(this).toggleClass('video-playing');
        jQuery(this).closest('.modal-video-container').find('.modal-video').toggleClass('reveal-modal');
        jQuery(this).closest('.modal-video-container').find('video').get(0).play();
    });

    jQuery('.modal-video-container .modal-video').click(function(event) {
        var culprit = event.target;
        if (jQuery(culprit).hasClass('modal-video')) {
            jQuery(this).find('video').get(0).pause();
        }
    });

    // Hover gallery
    jQuery('.hover-gallery').each(function(){
    	var that = jQuery(this),
    		timerId = setInterval(function(){
    					scrollHoverGallery(that);
    				  }, 
    				  	jQuery(this).closest('.hover-gallery').attr('speed')
    				  );
		
		that.closest('.hover-gallery').attr('timerId', timerId );
		
		that.find('li').bind('hover, mouseover, mouseenter, click', function(e){
			e.stopPropagation();
			clearInterval(timerId);
		});
	
	});
	

    jQuery('.hover-gallery li').mouseenter(function() {
        clearInterval(jQuery(this).closest('.hover-gallery[timerId]').attr('timerId'));
        jQuery(this).parent().find('li.active').removeClass('active');
        jQuery(this).addClass('active');
    });
    
    // Pricing table remove emphasis on hover
    jQuery('.pricing-option').each(function(){
    	jQuery(this).parents('.vc_column_container').addClass('no-pad pricing-table-wrap');
    });
    jQuery('.pricing-option').mouseenter(function() {
        jQuery(this).parents('.vc_row').find('.pricing-option').removeClass('active');
        jQuery(this).addClass('active');
    });

    // Map overlay switch
    jQuery('.map-toggle .switch').click(function() {
        jQuery(this).closest('.contact').toggleClass('toggle-active');
        jQuery(this).toggleClass('toggle-active');
    });

    // Twitter Feed
    jQuery('.tweets-feed').each(function(index) {
        jQuery(this).attr('id', 'tweets-' + index);
    }).each(function(index) {

        function handleTweets(tweets) {
            var x = tweets.length;
            var n = 0;
            var element = document.getElementById('tweets-' + index);
            var html = '<ul class="slides">';
            while (n < x) {
                html += '<li>' + tweets[n] + '</li>';
                n++;
            }
            html += '</ul>';
            element.innerHTML = html;
            return html;
        }

        twitterFetcher.fetch(jQuery('#tweets-' + index).attr('data-widget-id'), '', 5, true, true, true, '', false, handleTweets);

    });

    // Instagram Feed
    jQuery.fn.spectragram.accessData = {
        accessToken: '1406933036.fedaafa.feec3d50f5194ce5b705a1f11a107e0b',
        clientID: 'fedaafacf224447e8aef74872d3820a1'
    };

    jQuery('.instafeed').each(function() {
        jQuery(this).children('ul').spectragram('getUserFeed', {
            query: jQuery(this).attr('data-user-name')
        });
    });
    
    // Sort tabs into 2 ul's
    jQuery('.tabbed-content').each(function(){
    	jQuery(this).append('<ul class="content"></ul>');
    });
    
    jQuery('.tabs li').each(function(){
    	var originalTab = jQuery(this), activeClass = "";
    	if(originalTab.is('.tabs li:first-child')){
    		activeClass = ' class="active"';
    	}
    	var tabContent = originalTab.find('.tab-content').detach().wrap('<li'+activeClass+'></li>').parent();
    	originalTab.closest('.tabbed-content').find('.content').append(tabContent);
    });
    
    jQuery('.tabs li').click(function(){
    	jQuery(this).closest('.tabs').find('li').removeClass('active');
    	jQuery(this).addClass('active');
    	var liIndex = jQuery(this).index() + 1;
    	jQuery(this).closest('.tabbed-content').find('.content li').removeClass('active');
    	jQuery(this).closest('.tabbed-content').find('.content li:nth-child('+liIndex+')').addClass('active');
    });
    
    // Remove screen when user clicks on the map, then add it again when they scroll
    jQuery('.screen').click(function(){
    	jQuery(this).removeClass('screen');
    });
    
    jQuery('a.js-activated').not('a.js-activated[href^="#"]').click(function(){
    	var url = jQuery(this).attr('href');
    	window.location.href = url;
    	return true;
    });

}); 
/*-----------------------------------------------------------------------------------*/
/*	WINDOW READY FUNCTIONS
/*-----------------------------------------------------------------------------------*/
jQuery(window).load(function() { 
	"use strict";

    // Initialize twitter feed
    var setUpTweets = setInterval(function() {
        if (jQuery('.tweets-slider').find('li.flex-active-slide').length) {
            clearInterval(setUpTweets);
            return;
        } else {
            if (jQuery('.tweets-slider').length) {
                jQuery('.tweets-slider').flexslider({
                    directionNav: false,
                    controlNav: false
                });
            }
        }
    }, 500);

    // Append Instagram BGs
    var setUpInstagram = setInterval(function() {
        if (jQuery('.instafeed li').hasClass('bg-added')) {
            clearInterval(setUpInstagram);
            return;
        } else {
            jQuery('.instafeed li').each(function() {
                var imgSrc = jQuery(this).find('img').attr('src');
                jQuery(this).css('background', 'url("' + imgSrc + '")');
                jQuery(this).find('img').css('opacity', 0);
                jQuery(this).css('background-position', '50% 0%');
                jQuery(this).addClass('bg-added');
            });
            jQuery('.instafeed').addClass('fadeIn');
        }
    }, 500);

});