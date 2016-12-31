/*-----------------------------------------------------------------------------------*/
/* WIDTH CLASS
/*-----------------------------------------------------------------------------------*/
$(document).ready(function(){
"use strict";
    assign_bootstrap_mode();
    $(window).resize(function() {
        assign_bootstrap_mode();
    });
});

function assign_bootstrap_mode() {
    width = $( window ).width();
    var mode = '';
    if (width<768) {
        mode = "mode-xs";
    }
    else if (width<992) {
        mode = "mode-sm";
    }
    else if (width<1200) {
	    $('.dropdown-submenu .dropdown-menu li a').on('touchstart', function(e) {
	    e.preventDefault();
	    window.location.href = $(this).attr('href');
		});
    }
    else if (width>1200) {
        mode = "mode-lg";
    }
    $("body").removeClass("mode-xs").removeClass("mode-sm").removeClass("mode-md").removeClass("mode-lg").addClass(mode);
}
/*-----------------------------------------------------------------------------------*/
/*	CONTENT SLIDER
/*-----------------------------------------------------------------------------------*/
/**************************************************************************
 * jQuery Plugin for Content Slider
 * @version: 1.0
 * @requires jQuery v1.8 or later
 * @author ThunderBudies
 **************************************************************************/

$(document).ready(function () {

    var mainContOut = 0;
    var animclass = "fader"; //fader // slider


    var speed = 1000;

    jQuery.fn.extend({
        unwrapInner: function (selector) {
            return this.each(function () {
                var t = this,
                    c = $(t).children(selector);
                if (c.length === 1) {
                    c.contents().appendTo(t);
                    c.remove();
                }
            });
        }
    });




	///////////////////////////
	// GET THE URL PARAMETER //
	///////////////////////////
	function getUrlVars(hashdivider)
			{
				var vars = [], hash;
				var hashes = window.location.href.slice(window.location.href.indexOf(hashdivider) + 1).split('_');
				for(var i = 0; i < hashes.length; i++)
				{
					hashes[i] = hashes[i].replace('%3D',"=");
					hash = hashes[i].split('=');
					vars.push(hash[0]);
					vars[hash[0]] = hash[1];
				}
				return vars;
			}
	////////////////////////
	// GET THE BASIC URL  //
	///////////////////////
    function getAbsolutePath() {
		    var loc = window.location;
		    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
		    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    //////////////////////////
	// SET THE URL PARAMETER //
	///////////////////////////
    function updateURLParameter(paramVal){
	    	var baseurl = window.location.pathname.split("#")[0];
	    	var url = baseurl.split("#")[0];
            if(url[url.length-3]=="/")
                url = url.substring(url.length-3, url.length);
	    	if (paramVal==undefined) paramVal="";

	  		par='#'+paramVal;

		    window.location.replace(url+par);
	}


    var items = jQuery('.content-slider.items a');
    var deeplink = getUrlVars("#");





    jQuery.ajaxSetup({
        // Disable caching of AJAX responses */
        cache: false
    });

    // FIRST ADD THE HANDLING ON THE DIFFERENT PORTFOLIO ITEMS
    items.slice(0, items.length).each(function (i) {
        var item = jQuery(this);
        item.data('index', i);

        if (jQuery.support.leadingWhitespace == false){

        	var conurl = jQuery(this).data('contenturl');
            var dataId = jQuery(this).data('id');
            var dataLang = jQuery(this).data('lang');

            conurl = conurl + "?dataId=" + dataId + "&dataLang=" + dataLang;
        	item.attr('href',conurl);

        }

        else
        // THE HANDLING IN CASE ITEM IS CLICKED
        item.click(function () {
	        item.addClass("clicked-no-slide-anim");
            var cur = item.data('index');
            var hashy = window.pageYOffset;



            if (jQuery('.dark-wrapper.fixed').length == 0) {
                // PREPARE THE CURRENT CONTENT OF BODY AND WRAP IT
                jQuery('.body-wrapper').wrapInner('<div class="fullcontent-slider-getaway-wrapper"><div class="fullcontent-slider-getaway-slide"></div></div>');
                var origheight = jQuery('.fullcontent-slider-getaway-slide').height();

                //BUILD THE PANEL

                jQuery('body').append('<div class="navcoverpage light-wrapper"></div>' +
                    '<div class="navfake dark-wrapper">' +

                    '<div class="page-title">' +
                    '<div class="container inner">' +
                    '<div class="navigation">' +
                    '<a href="#" id="gwi-thumbs" class="btn pull-left back">Back</a>' +/*
                    '<a href="#" id="gwi-next" class="btn pull-right rm0 nav-next-item">Next</a>' +
                    '<a href="#" id="gwi-prev" class="btn pull-right rm5 nav-prev-item">Prev</a>' + */
                    '</div>' +
                    '<div class="clear"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>');

                //ADD A NEW CONTENT WRAPPER
                var conurl = jQuery(this).data('contenturl');
                var concon = jQuery(this).data('contentcontainer');
                var dataId = jQuery(this).data('id');
                var dataLang = jQuery(this).data('lang');

                conurl = conurl + "?dataId=" + dataId + "&dataLang=" + dataLang;

                updateURLParameter(conurl);

                var extraclass = "";


                jQuery('body').append('<div class="preparedtostart right fullcontent-content-wrapper-new ' + extraclass + ' ' + animclass + '"></div>');

                // FIRST WE LOAD THE VERY FIRST ITEM, WHEN PANEL IS ALREAD IN
                setTimeout(function () {
                    if (conurl != undefined && conurl.length > 0) {

                        jQuery('.fullcontent-content-wrapper-new').load(conurl + " " + concon, function () {


                            jQuery('.preparedtostart.fullcontent-content-wrapper-new').find('.footer-wrapper').remove();
                            jQuery('.navfake h1').html(jQuery('.fullcontent-content-wrapper-new .title').html()).removeClass("novisibility");
                            animateContents(mainContOut, jQuery('.fullcontent-slider-getaway-slide'), jQuery('.preparedtostart.fullcontent-content-wrapper-new'), speed);
                            jQuery('.fullcontent-slider-getaway-slide').css({
                                height: "100%",
                                overflow: 'hidden'
                            })
                            jQuery('body,html').animate({
                                scrollTop: "0px"
                            }, {
                                duration: 10,
                                queue: false
                            });

                            var callback = new Function(item.data('callback'));
                            callback();
                        });

                    } else {
                        jQuery('.fullcontent-content-wrapper-new').append(jQuery(this).data('content'));
                    }
                }, speed + 200);


                // SHOW THE PANEL
                jQuery('.navfake').animate({
                    left: '0px'
                }, {
                    duration: speed - 200,
                    queue: false
                });
                jQuery('.navcoverpage').animate({
                    left: '0px'
                }, {
                    duration: speed - 200,
                    queue: false
                });




                // THE CLICK ON THE THUMB SHOULD ACT LIKE
                jQuery(document).on('click', '#gwi-thumbs', function () {
                	 updateURLParameter();
	                jQuery('.clicked-no-slide-anim').removeClass('clicked-no-slide-anim');
                    jQuery('.preparedtoleave').animate({
                        opacity: 0
                    }, {
                        duration: speed - 100,
                        queue: false,
                        complete: function () {
                            jQuery(this).remove();
                        }
                    });
                    setTimeout(function () {
                        jQuery('body,html').animate({
                            scrollTop: hashy + "px"
                        }, {
                            duration: 10,
                            queue: false
                        });

                        jQuery('.fullcontent-slider-getaway-slide').css({
                            visibility: 'visible'
                        }).animate({
                            left: '0px'
                        }, {
                            duration: speed,
                            queue: false
                        });
                        jQuery('.navcoverpage').animate({
                            left: '100%'
                        }, {
                            duration: speed,
                            queue: false,
                            complete: function () {
                                jQuery(this).remove();
                            }
                        });
                        jQuery('.navfake').animate({
                            left: '100%'
                        }, {
                            duration: speed,
                            queue: false,
                            complete: function () {
                                jQuery(this).remove();
                            }
                        });
                        jQuery('.fullcontent-slider-getaway-slide').unwrap().find('div:nth(0)').unwrap();

                    }, speed - 100);


                    return false;
                }) // END OF CLICK ON ICON-TH

                // THE CLICK ON THE PREV OR NEXT BUTTON
                jQuery('#gwi-next').click(function () {

                    cur = cur + 1;
                    if (cur > items.length) cur = 0;
                    var nextitem;
                    items.slice(cur, cur + 1).each(function () {
                        nextitem = jQuery(this);
                    });
                    swapContents(nextitem, 1, animclass, speed);
                    return false;

                });

                // THE CLICK ON THE PREV OR NEXT BUTTON
                jQuery('#gwi-prev').click(function () {
                    cur = cur - 1;
                    if (cur < 0) cur = items.length - 1;
                    var nextitem;
                    items.slice(cur, cur + 1).each(function () {
                        nextitem = jQuery(this);
                    });
                    swapContents(nextitem, 0, animclass, speed);
                    return false;
                });

            }
            return false;
        }); // END OF CLICK HANDLING ON PORTFOLIO ITEM

   }); // END OF HANDLING ON EACH PORTFOLIO ITEM

   var firstfound=0;
   items.slice(0, items.length).each(function (i) {
     var item=jQuery(this);
   	 if (deeplink!=undefined && deeplink.length>0 && deeplink == jQuery(this).data('contenturl')) {
		   	 	if (firstfound==0) {

	  	 			setTimeout(function() {item.click();},2000);
	  	 			firstfound=1;
	  	 		}
    	    }
   });


    // ANIMATE THE CONTENT CHANGE
    function animateContents(mainContOut, oldbody, newbody, speed) {
        // ANIMATE THE CURRENT BODY OUT OF THE SCREEN
        if (mainContOut != 0) oldbody.delay(0).animate({
            left: '-100%'
        }, {
            duration: speed,
            queue: false,
            complete: function () {
                jQuery(this).css({
                    visibility: 'hidden'
                });
            }
        })

        //jQuery('.navcoverpage').animate({'opacity':0},{duration:1200,queue:false});
        newbody.delay(0).css({
            opacity: 0
        }).animate({
            left: '0px',
            opacity: 1
        }, {
            duration: speed,
            queue: false
        });
        newbody.removeClass('preparedtostart').addClass('preparedtoleave');

    }

    // SWAP CONTENTS
    function swapContents(nextitem, dir, animclass, speed) {


        var lpx = "0px";
        var lpr = "-100%";
        var pos = "right";
        var extraclass = "";

        if (dir == 0) {
            pos = "left"
            lpr = "100%";
        }

        if (animclass == "fader") {
            lpr = "0px";
        }
        jQuery('.preparedtoleave').addClass("killme");



        //ADD A NEW CONTENT WRAPPER
        try {


            var conurl = nextitem.data('contenturl');
            var concon = nextitem.data('contentcontainer');

             updateURLParameter(conurl);



            if (jQuery('.preparedtostart').length == 0) {
                jQuery('body').append('<div class="preparedtostart ' + pos + ' ' + extraclass + ' ' + animclass + ' fullcontent-content-wrapper-new"></div>');
            }


            jQuery('.preparedtostart.fullcontent-content-wrapper-new').load(conurl + " " + concon, function () {


                jQuery('body,html').animate({
                    scrollTop: "0px"
                }, {
                    duration: 10,
                    queue: false
                });
                jQuery('.preparedtostart.fullcontent-content-wrapper-new').css({
                    'opacity': 0
                }).animate({
                    left: lpx,
                    opacity: 1
                }, {
                    duration: speed,
                    queue: false
                });
                jQuery('.killme').animate({
                    left: lpr,
                    opacity: 0
                }, {
                    duration: speed + 100,
                    queue: false,
                    complete: function () {
                        jQuery(this).remove();
                    }
                });
                jQuery('body').find('.preparedtostart.fullcontent-content-wrapper-new').each(function (i) {
                    if (!jQuery(this).hasClass("killme")) {
                        jQuery('.navfake h1').html(jQuery(this).find('.title').html());
                    }
                });
                var callback = new Function(nextitem.data('callback'));
                callback();
                jQuery('.preparedtostart.fullcontent-content-wrapper-new').removeClass('preparedtostart').addClass('preparedtoleave');

            });
        } catch (e) {}



    }
});
/*-----------------------------------------------------------------------------------*/
/*	OWL CAROUSEL
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($) {
              $('.testimonials').owlCarousel({
                items: 1,
                nav:true,
                navText: ['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
                dots: false,
                autoHeight: true,
                loop: true,
                margin: 0,
              });
              
              $('.portfolio-slider').owlCarousel({
                items: 1,
                nav:true,
                navText: ['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
                dots: true,
                autoHeight: false,
                loop: true,
                margin: 0,
                navContainerClass: 'owl-slider-nav',
				navClass: [ 'owl-slider-prev', 'owl-slider-next' ],
				controlsClass: 'owl-slider-controls'
              });
              
              $('.carousel-gallery').owlCarousel({
			    margin:10,
			    navText: ['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
			    navContainerClass: 'owl-slider-nav',
				navClass: [ 'owl-slider-prev', 'owl-slider-next' ],
				controlsClass: 'owl-slider-controls',
			    nav:true,
			    dots: false,
			    items:1,
			    responsive:{
			    	450:{
			            items:2
			        },
			        1400:{
			            items:3
			        }
			    }
			});            
});
/*-----------------------------------------------------------------------------------*/
/*	VIDEO
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
    jQuery('.player').fitVids();
});
/*-----------------------------------------------------------------------------------*/
/*	CALL PORTFOLIO SCRIPTS
/*-----------------------------------------------------------------------------------*/
function callPortfolioScripts() {

    		  jQuery('.player').fitVids();
    
    		  $('.portfolio-slider').owlCarousel({
                items: 1,
                nav:true,
                navText: ['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
                dots: true,
                autoHeight: false,
                loop: true,
                margin: 0,
                navContainerClass: 'owl-slider-nav',
				navClass: [ 'owl-slider-prev', 'owl-slider-next' ],
				controlsClass: 'owl-slider-controls'
              });
              
              $('.carousel-gallery').owlCarousel({
			    margin:10,
			    navText: ['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
			    navContainerClass: 'owl-slider-nav',
				navClass: [ 'owl-slider-prev', 'owl-slider-next' ],
				controlsClass: 'owl-slider-controls',
			    nav:true,
			    dots: false,
			    items:1,
			    responsive:{
			    	450:{
			            items:2
			        },
			    	1400:{
			            items:3
			        }
			    } 
			}); 
};
/*-----------------------------------------------------------------------------------*/
/*	MENU
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    $('.js-activated').dropdownHover({
        instantlyCloseOthers: false,
        delay: 0
    }).dropdown();


    $('.dropdown-menu a, .social .dropdown-menu, .social .dropdown-menu input').click(function (e) {
        e.stopPropagation();
    });

});
/*-----------------------------------------------------------------------------------*/
/*	STICKY HEADER
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {

    var menu = $('.navbar'),
        pos = menu.offset();

    $(window).scroll(function () {
        if ($(this).scrollTop() > pos.top + menu.height() && menu.hasClass('default') && $(this).scrollTop() > 200) {
            menu.fadeOut('fast', function () {
                $(this).removeClass('default').addClass('fixed').fadeIn('fast');
            });
        } else if ($(this).scrollTop() <= pos.top + 200 && menu.hasClass('fixed')) {
            menu.fadeOut(0, function () {
                $(this).removeClass('fixed').addClass('default').fadeIn(0);
            });
        }
    });

});

$(document).ready(function(){ 
$('.navbar .nav li a').on('click',function(){
	    $('.navbar .navbar-collapse.in').collapse('hide');
	})
	});


/*-----------------------------------------------------------------------------------*/
/*	LOCALSCROLL & SCROLLTO
/*-----------------------------------------------------------------------------------*/
/**
* jQuery.LocalScroll - Animated scrolling navigation, using anchors.
* Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
* Dual licensed under MIT and GPL.
* Date: 3/11/2009
* @author Ariel Flesler
* @version 1.2.7
**/
(function($){var l=location.href.replace(/#.*/,'');var g=$.localScroll=function(a){$('body').localScroll(a)};g.defaults={duration:1e3,axis:'y',event:'click',stop:true,target:window,reset:true};g.hash=function(a){if(location.hash){a=$.extend({},g.defaults,a);a.hash=false;if(a.reset){var e=a.duration;delete a.duration;$(a.target).scrollTo(0,a);a.duration=e}i(0,location,a)}};$.fn.localScroll=function(b){b=$.extend({},g.defaults,b);return b.lazy?this.bind(b.event,function(a){var e=$([a.target,a.target.parentNode]).filter(d)[0];if(e)i(a,e,b)}):this.find('a,area').filter(d).bind(b.event,function(a){i(a,this,b)}).end().end();function d(){return!!this.href&&!!this.hash&&this.href.replace(this.hash,'')==l&&(!b.filter||$(this).is(b.filter))}};function i(a,e,b){var d=e.hash.slice(1),f=document.getElementById(d)||document.getElementsByName(d)[0];if(!f)return;if(a)a.preventDefault();var h=$(b.target);if(b.lock&&h.is(':animated')||b.onBefore&&b.onBefore.call(b,a,f,h)===false)return;if(b.stop)h.stop(true);if(b.hash){var j=f.id==d?'id':'name',k=$('<a> </a>').attr(j,d).css({position:'absolute',top:$(window).scrollTop(),left:$(window).scrollLeft()});f[j]='';$('body').prepend(k);location=e.hash;k.remove();f[j]=d}h.scrollTo(f,b).trigger('notify.serialScroll',[f])}})(jQuery);
/**
 * Copyright (c) 2007-2012 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.5 BETA
 */
;(function($){var h=$.scrollTo=function(a,b,c){$(window).scrollTo(a,b,c)};h.defaults={axis:'xy',duration:parseFloat($.fn.jquery)>=1.3?0:1,limit:true};h.window=function(a){return $(window)._scrollable()};$.fn._scrollable=function(){return this.map(function(){var a=this,isWin=!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!isWin)return a;var b=(a.contentWindow||a).document||a.ownerDocument||a;return/webkit/i.test(navigator.userAgent)||b.compatMode=='BackCompat'?b.body:b.documentElement})};$.fn.scrollTo=function(e,f,g){if(typeof f=='object'){g=f;f=0}if(typeof g=='function')g={onAfter:g};if(e=='max')e=9e9;g=$.extend({},h.defaults,g);f=f||g.duration;g.queue=g.queue&&g.axis.length>1;if(g.queue)f/=2;g.offset=both(g.offset);g.over=both(g.over);return this._scrollable().each(function(){if(e==null)return;var d=this,$elem=$(d),targ=e,toff,attr={},win=$elem.is('html,body');switch(typeof targ){case'number':case'string':if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=$(targ,this);if(!targ.length)return;case'object':if(targ.is||targ.style)toff=(targ=$(targ)).offset()}$.each(g.axis.split(''),function(i,a){var b=a=='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,old=d[key],max=h.max(d,a);if(toff){attr[key]=toff[pos]+(win?0:old-$elem.offset()[pos]);if(g.margin){attr[key]-=parseInt(targ.css('margin'+b))||0;attr[key]-=parseInt(targ.css('border'+b+'Width'))||0}attr[key]+=g.offset[pos]||0;if(g.over[pos])attr[key]+=targ[a=='x'?'width':'height']()*g.over[pos]}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)=='%'?parseFloat(c)/100*max:c}if(g.limit&&/^\d+$/.test(attr[key]))attr[key]=attr[key]<=0?0:Math.min(attr[key],max);if(!i&&g.queue){if(old!=attr[key])animate(g.onAfterFirst);delete attr[key]}});animate(g.onAfter);function animate(a){$elem.animate(attr,f,g.easing,a&&function(){a.call(this,e,g)})}}).end()};h.max=function(a,b){var c=b=='x'?'Width':'Height',scroll='scroll'+c;if(!$(a).is('html,body'))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,html=a.ownerDocument.documentElement,body=a.ownerDocument.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);
$(document).ready(function(){ 
    $('.navbar, .smooth').localScroll({
	    hash: true
    });
  });
/*-----------------------------------------------------------------------------------*/
/*	SCROLL NAVIGATION HIGHLIGHT
/*-----------------------------------------------------------------------------------*/
$(document).ready(function() {
	headerWrapper		= parseInt($('.navbar').height());
	
	
	var shrinked_header_height = 53;
	var header_height = $('.navbar').height();
	
	$('.offset').css('padding-top', header_height + 'px');
    $('.anchor').css('padding-top', shrinked_header_height + 'px');  
    $('.anchor').css('margin-top', -(shrinked_header_height) + 'px'); 
    
	offsetTolerance	= -(header_height);
	
	//Detecting user's scroll
	$(window).scroll(function() {
	
		//Check scroll position
		scrollPosition	= parseInt($(this).scrollTop());
		
		//Move trough each menu and check its position with scroll position then add current class
		$('.navbar ul a').each(function() {

			thisHref				= $(this).attr('href');
			thisTruePosition	= parseInt($(thisHref).offset().top);
			thisPosition 		= thisTruePosition - headerWrapper - offsetTolerance;
			
			if(scrollPosition >= thisPosition) {
				
				$('.current').removeClass('current');
				$('.navbar ul a[href='+ thisHref +']').parent('li').addClass('current');
				
			}
		});
		
		
		//If we're at the bottom of the page, move pointer to the last section
		bottomPage	= parseInt($(document).height()) - parseInt($(window).height());
		
		if(scrollPosition == bottomPage || scrollPosition >= bottomPage) {
		
			$('.current').removeClass('current');
			$('.navbar ul a:last').parent('li').addClass('current');
		}
	});
	
});
/*-----------------------------------------------------------------------------------*/
/*	RETINA
/*-----------------------------------------------------------------------------------*/
$(function() {
			$('.retina').retinise();
		});
/*-----------------------------------------------------------------------------------*/
/*	ISOTOPE CLASSIC PORTFOLIO
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    var $container = $('.fix-portfolio .items');
    $container.imagesLoaded(function () {
        $container.isotope({
            itemSelector: '.item',
            layoutMode: 'fitRows'
        });
    });

    $(window).on('resize', function () {
        $('.fix-portfolio .items').isotope('reLayout')
    });
    
    $('.fix-portfolio .filter li a').click(function () {

        $('.fix-portfolio .filter li a').removeClass('active');
        $(this).addClass('active');

        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector
        });

        return false;
    });
});
/*-----------------------------------------------------------------------------------*/
/*	REVOLUTION
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function() {
jQuery('.fullscreenbanner').revolution(
	{
		delay: 9000,
		startwidth: 1170,
		startheight: 550,
		hideThumbs: 200,
		fullWidth:"off",
		fullScreen:"on"
	});
});
/*-----------------------------------------------------------------------------------*/
/*	INSTAGRAM WIDGET
/*-----------------------------------------------------------------------------------*/
var widgetFeed = new Instafeed({
		target: 'instawidget',
        get: 'user',
        limit: 6,
        userId: 1215763826,
        accessToken: '1215763826.467ede5.aa54392aa9eb46f0b9e7191f7211ec3a',
        resolution: 'thumbnail',
        template: '<li><span class="icon-overlay"><a href="{{link}}" target="_blank"><img src="{{image}}" /></a></span></li>',
        after: function () {    
		    $('.icon-overlay a').prepend('<span class="icn-more"></span>');
		  }
    });
    
        $('#instawidget').each(function() {
    widgetFeed.run();
});
/*-----------------------------------------------------------------------------------*/
/*	FANCYBOX
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    $(".fancybox-media").fancybox({
        arrows: true,
        padding: 0,
        closeBtn: true,
        openEffect: 'fade',
        closeEffect: 'fade',
        prevEffect: 'fade',
        nextEffect: 'fade',
        helpers: {
            media: {},
            overlay: {
                locked: false
            },
            buttons: false,
            thumbs: {
                width: 50,
                height: 50
            },
            title: {
                type: 'inside'
            }
        },
        beforeLoad: function () {
            var el, id = $(this.element).data('title-id');
            if (id) {
                el = $('#' + id);
                if (el.length) {
                    this.title = el.html();
                }
            }
        }
    });
});
/*-----------------------------------------------------------------------------------*/
/*	PRETTIFY
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
    window.prettyPrint && prettyPrint()
});
/*-----------------------------------------------------------------------------------*/
/*	PARALLAX MOBILE
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    if (navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/webOS/i) ||
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/BlackBerry/i)) {
        $('.parallax').addClass('mobile');
    }
});
/*-----------------------------------------------------------------------------------*/
/*	FORM
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function ($) {
    $('.forms').dcSlickForms();
});
$(document).ready(function () {
    $('.comment-form input[title], .comment-form textarea, .forms textarea').each(function () {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
        }

        $(this).focus(function () {
            if ($(this).val() == $(this).attr('title')) {
                $(this).val('').addClass('focused');
            }
        });
        $(this).blur(function () {
            if ($(this).val() === '') {
                $(this).val($(this).attr('title')).removeClass('focused');
            }
        });
    });
});
/*-----------------------------------------------------------------------------------*/
/*	DATA REL
/*-----------------------------------------------------------------------------------*/
$('a[data-rel]').each(function () {
    $(this).attr('rel', $(this).data('rel'));
});
/*-----------------------------------------------------------------------------------*/
/*	TOOLTIP
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    if ($("[rel=tooltip]").length) {
        $("[rel=tooltip]").tooltip();
    }
});
/*-----------------------------------------------------------------------------------*/
/*	TABS
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    $('.tabs.tabs-top').easytabs({
        animationSpeed: 300,
        updateHash: false
    });
});
/*-----------------------------------------------------------------------------------*/
/*	IMAGE ICON HOVER
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    $('.icon-overlay a').prepend('<span class="icn-more"></span>');
});
/*-----------------------------------------------------------------------------------*/
/* NAV BASE LINK
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($) {
jQuery('a.js-activated').not('a.js-activated[href^="#"]').click(function(){
var url = $(this).attr('href');
window.location.href = url;
return true;
});
});