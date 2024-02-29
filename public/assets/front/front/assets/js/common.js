jQuery(document).ready(function () {
    "use strict";

    jQuery('.toggle').click(function () {
        jQuery('.shadow').show();
        jQuery('.submenu').toggleClass("show-menu");
        // if (jQuery('.submenu').is(":hidden")) {
        //     // jQuery('.submenu').slideDown("fast");
        //     jQuery('.submenu').show();
        //     jQuery('.submenu').addClass("show-menu");
        // } else {
        //     jQuery('.submenu').removeClass("show-menu");
        //     // jQuery('.submenu').slideUp("fast");
        // }
        return false;
    });
    jQuery('.shadow').click(function () {
        jQuery('.shadow').hide();
        jQuery('.submenu').toggleClass("show-menu");
        return false;
    });

    /*Phone Menu*/
    jQuery(".topnav").accordion({
        accordion: false,
        speed: 300,
        closedSign: '<i class="icon-chevron-left"></i>',
        openedSign: '<i class="icon-chevron-down"></i>'
    });

    $("#nav > li").hover(function () {
        var el = $(this).find(".level0-wrapper");
        el.hide();
        el.css("left", "0");
        el.stop(true, true).delay(150).fadeIn(300, "easeOutCubic");
    }, function () {
        $(this).find(".level0-wrapper").stop(true, true).delay(300).fadeOut(300, "easeInCubic");
    });
    var scrolled = false;

    jQuery("#nav li.level0.drop-menu").mouseover(function () {
        if (jQuery(window).width() >= 740) {
            jQuery(this).children('ul.level1').fadeIn(100);
        }
        return false;
    }).mouseleave(function () {
        if (jQuery(window).width() >= 740) {
            jQuery(this).children('ul.level1').fadeOut(100);
        }
        return false;
    });
    jQuery("#nav li.level0.drop-menu li").mouseover(function () {
        if (jQuery(window).width() >= 740) {
            jQuery(this).children('ul').css({top: 0, left: "165px"});
            var offset = jQuery(this).offset();
            if (offset && (jQuery(window).width() < offset.left + 325)) {
                jQuery(this).children('ul').removeClass("right-sub");
                jQuery(this).children('ul').addClass("left-sub");
                jQuery(this).children('ul').css({top: 0, left: "-167px"});
            } else {
                jQuery(this).children('ul').removeClass("left-sub");
                jQuery(this).children('ul').addClass("right-sub");
            }
            jQuery(this).children('ul').fadeIn(100);
        }
    }).mouseleave(function () {
        if (jQuery(window).width() >= 740) {
            jQuery(this).children('ul').fadeOut(100);
        }
    });

    jQuery("#best-seller-slider .slider-items").owlCarousel({
        items: 6, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 4], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false,
        autoplay: true
    });


    jQuery("#featured-slider .slider-items").owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    jQuery("#bag-seller-slider .slider-items").owlCarousel({
        items: 3, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    jQuery("#shoes-slider .slider-items").owlCarousel({
        items: 3, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    jQuery("#recommend-slider .slider-items").owlCarousel({
        items: 6, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    jQuery("#brand-logo-slider .slider-items").owlCarousel({
        autoPlay: true,
        items: 10, //10 items above 1000px browser width
        itemsDesktop: [1024, 8], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 5], // 3 items betweem 900px and 601px
        itemsTablet: [600, 4], //2 items between 600 and 0;
        itemsMobile: [320, 4],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
//		scrollPerPage : true,
        pagination: false
    });
    jQuery("#category-desc-slider .slider-items").owlCarousel({
        autoplay: true,
        items: 1, //10 items above 1000px browser width
        itemsDesktop: [1024, 1], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 1], // 3 items betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    jQuery("#more-views-slider .slider-items").owlCarousel({
        autoplay: true,
        items: 3, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    $("#related-products-slider .slider-items").owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    $("#upsell-products-slider .slider-items").owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false
    });
    jQuery("#more-views-slider .slider-items").owlCarousel({
        autoplay: true,
        items: 3, //10 items above 1000px browser width
        itemsDesktop: [1024, 4], //5 items between 1024px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: [320, 1],
        navigation: true,
        navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"],
        slideSpeed: 500,
        pagination: false

    });
    jQuery("ul.accordion li.parent, ul.accordion li.parents, ul#magicat li.open").each(function () {
        jQuery(this).append('<em class="open-close">&nbsp;</em>');
    });

    jQuery('ul.accordion, ul#magicat').accordionNew();

    jQuery("ul.accordion li.active, ul#magicat li.active").each(function () {
        jQuery(this).children().next("div").css('display', 'block');
    });
});

var isTouchDevice = ('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0);
jQuery(window).on("load", function () {

    if (isTouchDevice) {
        jQuery('#nav a.level-top').click(function (e) {
            $t = jQuery(this);
            $parent = $t.parent();
            if ($parent.hasClass('parent')) {
                if (!$t.hasClass('menu-ready')) {
                    jQuery('#nav a.level-top').removeClass('menu-ready');
                    $t.addClass('menu-ready');
                    return false;
                } else {
                    $t.removeClass('menu-ready');
                }
            }
        });
    }
    //on load
    jQuery().UItoTop();


}); //end: on load

//]]>

$(window).scroll(function () {
    if ($(this).scrollTop() > 1) {
        $('nav').addClass("sticky");
    } else {
        $('nav').removeClass("sticky");
    }
});

/*--------| UItoTop jQuery Plugin 1.1-------------------*/
(function ($) {
    jQuery.fn.UItoTop = function (options) {

        var defaults = {
            text: '',
            min: 200,
            inDelay: 600,
            outDelay: 400,
            containerID: 'toTop',
            containerHoverID: 'toTopHover',
            scrollSpeed: 1200,
            easingType: 'linear'
        };

        var settings = $.extend(defaults, options);
        var containerIDhash = '#' + settings.containerID;
        var containerHoverIDHash = '#' + settings.containerHoverID;

        jQuery('body').append('<a href="#" id="' + settings.containerID + '">' + settings.text + '</a>');
        jQuery(containerIDhash).hide().click(function () {
            jQuery('html, body').animate({scrollTop: 0}, settings.scrollSpeed, settings.easingType);
            jQuery('#' + settings.containerHoverID, this).stop().animate({'opacity': 0}, settings.inDelay, settings.easingType);
            return false;
        })
            .prepend('<span id="' + settings.containerHoverID + '"></span>')
            .hover(function () {
                jQuery(containerHoverIDHash, this).stop().animate({
                    'opacity': 1
                }, 600, 'linear');
            }, function () {
                jQuery(containerHoverIDHash, this).stop().animate({
                    'opacity': 0
                }, 700, 'linear');
            });

        jQuery(window).scroll(function () {
            var sd = $(window).scrollTop();
            if (typeof document.body.style.maxHeight === "undefined") {
                jQuery(containerIDhash).css({
                    'position': 'absolute',
                    'top': $(window).scrollTop() + $(window).height() - 50
                });
            }
            if (sd > settings.min)
                jQuery(containerIDhash).fadeIn(settings.inDelay);
            else
                jQuery(containerIDhash).fadeOut(settings.Outdelay);
        });

    };
})(jQuery);


/*--------| End UItoTop -------------------*/

function deleteCartInCheckoutPage() {
    $(".checkout-cart-index a.btn-remove2,.checkout-cart-index a.btn-remove").click(function (event) {
        event.preventDefault();
        if (!confirm(confirm_content)) {
            return false;
        }
    });
    return false;
}

function slideEffectAjax() {
    $('.top-cart-contain').mouseenter(function () {
        $(this).find(".top-cart-content").stop(true, true).show();
    });

    $('.top-cart-contain').mouseleave(function () {
        $(this).find(".top-cart-content").stop(true, true).hide();
    });
}

function deleteCartInSidebar() {
    if (is_checkout_page > 0) return false;
    $('#cart-sidebar a.btn-remove, #mini_cart_block a.btn-remove').each(function () {
    });
}

$(document).ready(function () {
    slideEffectAjax();
});


/*-------- End Cart js -------------------*/


jQuery.extend(jQuery.easing,
    {
        easeInCubic: function (x, t, b, c, d) {
            return c * (t /= d) * t * t + b;
        },
        easeOutCubic: function (x, t, b, c, d) {
            return c * ((t = t / d - 1) * t * t + 1) + b;
        },
    });

(function (jQuery) {
    jQuery.fn.extend({
        accordion: function () {
            return this.each(function () {

                function activate(el, effect) {
                    jQuery(el).siblings(panelSelector)[(effect || activationEffect)](((effect == "show") ? activationEffectSpeed : false), function () {
                        jQuery(el).parents().show();
                    });
                }
            });
        }
    });
})(jQuery);

jQuery(function ($) {
    $('.accordion').accordion();
    $('.accordion').each(function (index) {
        var activeItems = $(this).find('li.active');
        activeItems.each(function (i) {
            $(this).children('ul').css('display', 'block');
            if (i == activeItems.length - 1) {
                $(this).addClass("current");
            }
        });
    });

});


/*-------- End Nav js -------------------*/
/*============= Responsive Nav =============*/

/*============= End Responsive Nav =============*/

(function (jQuery) {
    jQuery.fn.extend({
        accordionNew: function () {
            return this.each(function () {
                var jQueryul = jQuery(this),
                    elementDataKey = 'accordiated',
                    activeClassName = 'active',
                    activationEffect = 'slideToggle',
                    panelSelector = 'ul, div',
                    activationEffectSpeed = 'fast',
                    itemSelector = 'li';
                if (jQueryul.data(elementDataKey))
                    return false;
                jQuery.each(jQueryul.find('ul, li>div'), function () {
                    jQuery(this).data(elementDataKey, true);
                    jQuery(this).hide();
                });
                jQuery.each(jQueryul.find('em.open-close'), function () {
                    jQuery(this).click(function (e) {
                        activate(this, activationEffect);
                        return void (0);
                    });
                    jQuery(this).bind('activate-node', function () {
                        jQueryul.find(panelSelector).not(jQuery(this).parents()).not(jQuery(this).siblings()).slideUp(activationEffectSpeed);
                        activate(this, 'slideDown');
                    });
                });
                var active = (location.hash) ? jQueryul.find('a[href=' + location.hash + ']')[0] : jQueryul.find('li.current a')[0];
                if (active) {
                    activate(active, false);
                }

                function activate(el, effect) {
                    jQuery(el).parent(itemSelector).siblings().removeClass(activeClassName).children(panelSelector).slideUp(activationEffectSpeed);
                    jQuery(el).siblings(panelSelector)[(effect || activationEffect)](((effect == "show") ? activationEffectSpeed : false), function () {
                        if (jQuery(el).siblings(panelSelector).is(':visible')) {
                            jQuery(el).parents(itemSelector).not(jQueryul.parents()).addClass(activeClassName);
                        } else {
                            jQuery(el).parent(itemSelector).removeClass(activeClassName);
                        }
                        if (effect == 'show') {
                            jQuery(el).parents(itemSelector).not(jQueryul.parents()).addClass(activeClassName);
                        }
                        jQuery(el).parents().show();
                    });
                }
            });
        }
    });
})(jQuery);


/*============= End Left Nav =============*/
