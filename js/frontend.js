var App = {

    current: "home",

    log: function (value) {
        "undefined" != typeof console && App.settings.debug && console.log(value);
    },

    settings: {
        speed: 200,
        debug: true
    },

    preloader: function (callback) {

        var images = [];
        $('.js__preload').each(function (i, el) {
            images.push($(el).attr('src') || el.style.backgroundImage.replace('url("', "").replace('")', ""));
        });

        var els = {};

        var count = images.length;

        for (var i = 0; i < count; i++) {
            els[i] = new Image();
            els[i].onload = function () {
                //console.log(count);
                count--;
                if (count == 0 && typeof callback == "function") {
                    //callback();
                }
            };
            els[i].onerror = function () {
                count--;
            };
            els[i].src = images[i];
        }

        setTimeout(callback, 1200);
    },


    // ONLY FOR DEV PURPOSE
    loadThis: function (section, slide) {
        $('#menu').removeClass('active');
        $('#section_' + section).addClass('active');
        $('#slide_' + slide).addClass('active');
        
        //App.log('Hyperjump to: '+section+' section, '+slide+' slide');
    },

    init: function () {

        //App.log('App: init!');

        App.initAssets();
        
        //App.preloader(App.removeSplashScreen);
        var titlePosition = $(".wmo-headline-wrap").position();
        var introPosition = $(".wmo-slide-text__content").position();

        if (titlePosition!=undefined && titlePosition.left) {
            //console.log('title ' + titlePosition.left);
            //console.log('intro ' + introPosition.left);
            var number = titlePosition.left;

            //$(".wmo-intro").css('margin-left', (number) + 'px');
            $(".wmo-slide-text__content").css('margin-left', (number) + 'px');
            $(".wmo-slide-text__content").css('left', 0);
        }


        $('.wmo-slide-text__content').each(App.initScroll);
        $('.wmo-slide-welcome__first-log').each(App.initScroll);
        $('.wmo-slide-welcome__second-log').each(App.initScroll);
        $('.wmo-slide-split__first-log').each(App.initScroll);
        $('.wmo-slide-split__second-log').each(App.initScroll);
        $('.wmo-quotes-normal').each(App.initScroll);

        $('.procedure-content').each(App.initScroll);

        var timer;
        $(document).mousemove(function () {
            if (timer) {
                clearTimeout(timer);
                timer = 0;
            }

            $('.js__go_prev').fadeIn(300);
            $('.js__go_next').fadeIn(300);
            $('.wmo-splash-screen-close').fadeIn(300);
            timer = setTimeout(function () {
                $('.js__go_prev').fadeOut(200);
                $('.js__go_next').fadeOut(200);
                $('.wmo-splash-screen-close').fadeOut(200);
            }, 3000)
        });
        // only for dev. comment this string for test and rev
        //App.loadThis(1, 1);
        //setTimeout(App.pyramidHelper, 2000);
        //$(window).on('resize', App.pyramidHelper);


        setTimeout(function () {
            $('.split_part.ps-container').each(function () {
                if (!$(this).hasClass('with-img') && $(this).hasClass('ps-active-y')) {
                    console.log('parent - ' + $(this).height());
                    console.log('child - ' + $(this).find('div').height());
                    console.log('hoho');
                    $(this).find('div').removeClass('vertical-centered');
                    //alert($(this).find('div').removeClass('vertical-centered'));
                }

            });
        }, 1);

    },

    removeSplashScreen: function () {
        $('.wmo-splash-screen:not(.slide-mode)').fadeOut(App.settings.speed); // myone
    },

    gotoSection: function () {


        var target = $(this).data('target');
        var $target = $("#" + target);
        $('.wmo-section.active').removeClass('active');
        $('.wmo-slide.active').removeClass('active');
        $('.wmo-splash-screen').fadeOut(App.settings.speed);
        
        $('.wmo-next-button').show();
        $('.wmo-next-button .js__go_prev').hide();
        
        $('body').removeClass('active-sidebar');
        
        App.slideChangeActions($target.find('article:first'), null);
        

        $('#menu').removeClass('active');

        $target.addClass('active');
        $target.find('article:first').addClass('active');

        App.initBread($target);
    },

    goToMenu: function () {
        App.slideChangeActions();

        $('body').removeClass('active-sidebar');

        $('.wmo-section.active').removeClass('active');
        $('.wmo-slide.active').removeClass('active');
        this.removeSplashScreen();

        //if(this.current == "home") {
        $('#headline').text('');
        $('.wmo-back-button').hide();
        $('.wmo-next-button').removeClass('_next-is-menu').hide();

        $('#menu').addClass('active');

        if (!$('.wmo-hearline-breadcrumbs__link').hasClass('active')) {
            $('.wmo-hearline-breadcrumbs__link').addClass('active');
        }
        this.removeBread();
        //}

    },

    slideChangeActions: function ($new, $old) {

        if ($old) {
            $old.find('.wmo-slide-video__close').trigger('click');
        }

        if (!$old || $new || ($new!==null && $new.data('type') != "welcome")) {
            $('.wmo-headline').removeClass('hide');
            $('.wmo-quote').removeClass('hide');
            $('.wmo-logo').removeClass('hide');
        }


        if ($new) {
            if ($new.data('type') == "welcome") {
                $('.wmo-headline').addClass('hide');
                $('.wmo-quote').addClass('hide');
                $('.wmo-logo').addClass('hide');
            }
            setTimeout(function(){
                App.correctSplitPlacement($new);
            },1);
        }
    },

    correctSplitPlacement:function(el){
        var splitText = el.find('.split_part.without-img.ps-container');
        if (typeof splitText !== "undefined") {
            var parentHeight = splitText.height();
            var childHeight = splitText.find('div').height();
            console.log('parent - ' + parentHeight);
            console.log('child - ' + childHeight);
            console.log('hoho');
            if (childHeight >= parentHeight) {

                splitText.find('div').removeClass('vertical-centered');
            }
        }
    },

    $getActive: function () {
        return $('.wmo-section.active .wmo-slide.active');
    },


    goPrev: function () {
        var $current = this.$getActive();
        var $prev = $current.prev('.wmo-slide');
        if ($prev.length) {
            $current.removeClass('active');
            $prev.addClass('active');
            this.changeSlideNameBread($prev);
            App.slideChangeActions($prev, $current);
            if($prev.length == 1){
                $('.wmo-next-button .js__go_prev').hide();
            }
        }else {
            $('.wmo-next-button .js__go_prev').hide();
        }
    },

    goNext: function () {        
        var $current = this.$getActive(),
            $next = $current.next('.wmo-slide');

        if ($next.length) {
            $current.removeClass('active');
            $next.addClass('active');
            this.changeSlideNameBread($next);
            App.slideChangeActions($next, $current);
            $('.wmo-next-button .js__go_prev').show();
        } else {
            this.goToMenu();
            App.slideChangeActions(null, $current);
            return;
        }

        if ($next.next().length == 0) {
            $('.wmo-next-button').addClass('_next-is-menu');
        }
    },

    initScroll: function () {
        var $this = $(this);

        $this.perfectScrollbar();
    },

    initBread: function ($target) {
        var breadSectionName = $('.wmo-hearline-breadcrumbs__item--section-name'),
            breadSlideName = $('.wmo-hearline-breadcrumbs__item--slide-name'),
            breadMainLink = $('.wmo-hearline-breadcrumbs__link'),
            sectionName = $target.data('name'),
            slideName = $target.find('article').data('name');

        breadMainLink.removeClass('active');
        
        breadSectionName.fadeIn(300).addClass('visible').text(sectionName);
        if (slideName) {
            breadSlideName.fadeIn(300).addClass('visible').text(slideName);
        }
    },

    removeBread: function () {
        var breadSectionName = $('.wmo-hearline-breadcrumbs__item--section-name'),
            breadSlideName = $('.wmo-hearline-breadcrumbs__item--slide-name');
        
        breadSectionName.fadeOut(300, function () {
            $(this).removeClass('visible').text('');
        });
        
        breadSlideName.fadeOut(300, function () {
            $(this).removeClass('visible').text('');
        });
    },

    changeSlideNameBread: function (slide) {
        var newSlideName = slide.data('name');
        breadSlideName = $('.wmo-hearline-breadcrumbs__item--slide-name');

        breadSlideName.fadeOut(300, function () {
            $(this).text(newSlideName).fadeIn(300);
        });
    },

    initAssets: function () {

        $('.wmo-slide-video__play').on('click', function () {
            var $this = $(this);
            var src = $this.data('src');

            if (src.search('youtu') > 0 || src.search('vim')) {
                src = src.replace("youtu.be/", "www.youtube.com/embed/").replace("/watch?v=", "/v/");
                src = src.replace('/vimeo.com/', '/player.vimeo.com/video/');
                src = src + "?autoplay=1&wmode=transparent";
                $this.parents('.wmo-slide-video').find('.wmo-slide-video__iframe').attr('src', src).removeClass('hide');
            } else {
                var $video = $this.parents('.wmo-slide-video').find('.wmo-slide-video__video');
                $video.attr('src', src).removeClass('hide');
                $video[0].play();
            }

            setTimeout(function () {
                $this.parents('.wmo-slide-video__poster').fadeOut(200);
            }, 200);
            return false;
        });

        $('.wmo-slide-video__close').on('click', function () {
            var $this = $(this);
            $this.siblings('.wmo-slide-video__poster').fadeIn(200, function () {
                $this.parents('.wmo-slide-video').find('.wmo-slide-video__iframe').attr('src', '').addClass('hide');
                $this.parents('.wmo-slide-video').find('.wmo-slide-video__video').attr('src', '').addClass('hide');
            });
            return false;
        });


    },

    /*    pyramidHelper: function () {
     var $p = $('.wmo-pyramid');
     var $img = $p.find('.wmo-pyramid-image img');
     var maxh = $p.height();
     var imgh = $img.height();
     if(maxh < imgh) {
     $img.parent().addClass('height-fix');
     } else {
     $img.parent().removeClass('height-fix');
     }
     }*/

    /*
        Toggle to show or hide sidebar menu
    */
    toggleSideBar: function() {
        if( $('body').hasClass('active-sidebar') ){
            $('body').removeClass('active-sidebar');
        }else{
            $('body').addClass('active-sidebar');
        }
    },

    /*
        Toggle to show or hide additional menu items
     */
    toggleAdditionalSideBarMenu: function() {
        if( $('.additional-nav-bar').hasClass('open') ){
            $('.nav-bar-menu .additional').removeClass('open');
            $('.additional-nav-bar').removeClass('open');
        }else{
            $('.nav-bar-menu .additional').addClass('open');
            $('.additional-nav-bar').addClass('open');
        }
    },

    /*
        Toggle to fullscreen mode
    */
    toggleFullScreen: function() {
        var el = document.body;
        if($('.fullscreen-toggle').hasClass('active')){
            $('.fullscreen-toggle').removeClass('active');
            if (document.cancelFullScreen) {  
                document.cancelFullScreen();  
            } else if (document.mozCancelFullScreen) {  
                document.mozCancelFullScreen();  
            } else if (document.webkitCancelFullScreen) {  
                document.webkitCancelFullScreen();  
            }else{
                // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
            
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }else{
            $('.fullscreen-toggle').addClass('active');
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen 
            || el.mozRequestFullScreen || el.msRequestFullScreen;
          
            if (requestMethod) {
          
                // Native full screen.
                requestMethod.call(el);
          
            } else if (typeof window.ActiveXObject !== "undefined") {
          
                // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
          
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }
    },

    /*
        Close Notification Bottom Field on Contents Template
    */
   closeNotiField: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('/presentations/set_session', { key_name: 'hide_noti', key_value: 1}, function(res){
            if(res == 'success'){
                $('.noti-field').removeClass('pop-up');
            }
        })
   }
};
$(".js__fancybox").fancybox({
    maxWidth: 800,
    maxHeight: 600,
    fitToView: false,
    width: '70%',
    height: '70%',
    autoSize: false,
    closeClick: false,
    openEffect: 'none',
    closeEffect: 'none',
});

//Contents slide view using slick slider
$('.slider-view').slick({
    // normal options...
    infinite: true,
    dots: false,
    draggable: true,
    slidesToShow: 4,
    arrows: true,

    prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style="display: block;">Previous</button>',
    nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button" style="display: block;">Next</button>',

    // the magic
    responsive: [{

        breakpoint: 1024,
        settings: {
            slidesToShow: 4,
            infinite: true
        }

        }, {

        breakpoint: 600,
        settings: {
            slidesToShow: 2,
            dots: true
        }

        }, {

        breakpoint: 300,
        settings: "unslick" // destroys slick

        }]
});

$(function(){
    //add pop-up class on notification bottom field on Contents Template
    $('.noti-field').addClass('pop-up');
    setTimeout(function(){
        $('body.template').addClass('loaded');
    }, 500)
});

$(document).on('click', '.js__goto_section', App.gotoSection);
$(document).on('click', '.js__go_back', App.goToMenu.bind(App));

$(document).on('click', '.wmo-splash-screen:not(.slide-mode) .splash-slide', App.goToMenu.bind(App));

$(document).on('click', '.js__go_prev', App.goPrev.bind(App));
$(document).on('click', '.wmo-section.screen-intro-content', App.goNext.bind(App));

//add Arrow key press functions

$(document).on('keyup', function(event){
    
    switch(event.keyCode) {
        case 39://right arrow
            App.goNext.bind(App)();
          break;
        case 37://left arrow
            App.goPrev.bind(App)();
          break;
        default://set as default
            console.log(event.keyCode);            
    }
    
});

$(document).on('click', '.sidebar-menu-active .active-btn', App.toggleSideBar);
$(document).on('click', '.nav-bar-menu .additional', App.toggleAdditionalSideBarMenu);
$(document).on('click', '.fullscreen-toggle', App.toggleFullScreen);
$(document).on('click', '.noti-close-btn', App.closeNotiField);
$(document).on('click', '.contents-content .screen-content', App.closeNotiField);
$(App.init);