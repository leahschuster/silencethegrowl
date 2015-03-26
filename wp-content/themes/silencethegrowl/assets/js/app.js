if(typeof jQuery == 'undefined') {
    console.log('%cERROR', 'color:red', ' - jQuery not found.')
} else {

var App;

!(function ($) {

    "use strict";

    App = window.APPLICATION = {};

    /**
     * Config
     * Debug toggling, environment, breakpoints, etc.
     */
    App.config = {

        environment : (window.location.href.match(/(localhost)/g) ? 'development' : 'production' ),
        debug: true,

        media_queries : {
            widescreen : 1400
        },

        compatibility : {
            input_placeholders : true,
            chrome_font_fix : false
        },

        wp : {
          theme_dir : 'wp-content/themes/silencethegrowl',
          image_path : '/wp-content/themes/silencethegrowl/assets/img'
        }
    }


   //ELEMENTS
    App.el = {
        modal          : $('.modal'),
        modal_bay      : document.getElementById('modal'),


        forms : { }
    };



    /**
     * Initiate Functions (document.onready & pjax:end)
     *
     */
    App.init = function(){
        App.initScripts();
        App.helpers.userAgentDetection();
        App.helpers.isUserAgent();
        App.events();
        App.scroll();
        App.donate();
        App.modals();
        App.lazyLoadVideo();
        App.konamiCode();
    
    };
  

    /**
     * Initialize Scripts
     *
     */
    App.initScripts = function(){

        // WOW.js
        if ( !window.WOW ) { return false; } else { new WOW().init(); }

    }

    /**
     * Event Bindings
     *
     */
    App.events = function(){

        //nav 'x' close
        // $(document).delegate('.nav-close', 'mouseup touchstart', function(event) {
        //     event.preventDefault();
        //     $('.nav-overlay').removeClass('active');
        //     $('.mobile-nav').removeClass('active');
        //     $(this).removeClass('active');
        //     $('.global-mobile').removeClass('active');
        // }); 

        // sharePop function for social sharing
        $(document).delegate('.share-pop', 'mouseup touchstart', function(event) {
            event.preventDefault();
            console.log('do this');
            window.open( $(this).data('url'), "myWindow", "status = 1, height = 500, width = 500, resizable = 0")
        });

    };




    /**
     * Scroll
     * 
     * @require `.scroll` class on <a>
     */
    App.scroll = function(){

        // <a> method manual
        $('a.scroll, li.scroll > a').click(function(e){
            e.preventDefault();

            var $this       = $(this),
                target_id   = $this.attr('href'),
                target      = $(target_id),
                duration    = (target.offset().top - $(window).scrollTop());

            App.helpers.animateScroll(target, duration, 'swing', 15);

        });


    };


    /* DONATE 
    ================================================== */
    App.donate = function(){
        var priceInterval ='.input-price-options label',
         inputAmountID ='#donately-amount';


         //Update Amount input when price is clicked
         //Click donate presets
         $(document).delegate(priceInterval, 'mouseup touchstart', function(event) {
              event.preventDefault();
              var newAmount = $(this).prev('input').val();
              $(inputAmountID).val(newAmount);
         }); 
         

         //Click Enter Payment Info button
         $(document).delegate('#donate_card_info', 'mouseup touchstart', function(event) {
              event.preventDefault();
              $('#donation').addClass('step-two');
         }); 



         //remove selected state of Price Interval box
         function removePriceSelection(){
              $('.input-price-options input').prop('checked', false);
         }

         //when Enter Amount is clicked
         $(inputAmountID).click( function(){
              removePriceSelection()
         });
    }


    /* MODALS 
        ================================================== */
        App.modals = function() {
            console.log('trigger modals');

          var modals            = App.el.modal,
              modal_bay         = App.el.modal_bay,
              modal_trigger     = $('.modal-trigger'),
              $modal_close      = $('.modal-close');

            // move all modals to modal bay
            if ( modals )
              modals.appendTo(modal_bay);

            // append the modal overlay to the body
            $('body').append('<div class="modal-overlay"></div>');
            var $modal_overlay = $('.modal-overlay');
            
            // attach modal trigger click handler
            modal_trigger.click(function (event) {
             event.preventDefault();

                // set relative vars
                var modal_id        = $(this).data('id'),
                    modal_target    = $(modal_id);

                // modal show func
                function modal_show() {
                    $modal_overlay.addClass('show');
                    setTimeout(function(){
                        modal_target.addClass('show');
                    }, 250)

                    modal_target.find('.lazyload').click()
                    console.log('click on lazyload', modal_target.find('.lazyload'))
                } modal_show();

                // modal hide func
                function modal_close() {
                    modal_target.removeClass('show');
                    //modal_target.stopVideo();
                    modal_target.find('.lazyload iframe').remove()

                    setTimeout(function(){
                        $modal_overlay.removeClass('show');
                        //modal_target.stopVideo();
                         
                    }, 150)
                }

                // esc keyup
                $(document).keyup(function(event) { 
                    if (event.keyCode == 27) { modal_close(); } 
                });
                // close button
                $modal_close.click(function() { 
                  modal_close(); 
                  //modal_target.stopVideo();
                });

                // click anywhere on overlay
                $modal_overlay.click(function() { modal_close(); })

            });

        };


        /**
         * Lazy load a video
         *
         * @markup <div class="lazyload" data-video-id="a4kiasd9" data-video-service="youtube"></div>
         *
         * @usage In the modal event binding, fire a click event on `.lazyload`, ex:
         *
         * $(this).find('.lazyload').click()
         */
        App.lazyLoadVideo = function() {

            $('.lazyload').click (function (event) {
                var $this           = $(this),
                    video_id        = $this.data('video-id'),
                    video_service   = $this.data('video-service'),
                    width           = $this.width(),
                    height          = $this.height();

                    // console.log(width, height);

                // embed code builder function
                function buildEmbed(service, id) {
                    if (service === 'youtube') {
                        var embed = '<iframe width="'+width+'" height="'+height+'" src="//www.youtube.com/embed/'+video_id+'?autoplay=1" frameborder="0" allowfullscreen></iframe>';
                        return embed;
                    }
                    if (service === 'vimeo') {
                        var embed = '<iframe src="//player.vimeo.com/video/'+video_id+'?title=0&amp;autoplay=1&amp;byline=0&amp;portrait=0&amp;badge=0" width="'+width+'" height="'+height+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                        return embed;
                    }
                }

                // build the embed code
                var embed_code = buildEmbed(video_service, video_id);

                // if iframe doesnt exists
                if ( $this.find('iframe').length <= 0 ) {
                    $this.append( embed_code )
                } else {
                    // if it does, remove it first
                    $this.find('iframe').remove()
                    $this.append( embed_code )
                }
            });
        }


    /**
     * Konami Code
     *
     */
    App.konamiCode = function() {

        var secret = '38403840373937396665',
            input  = '',
            timer;

        $(document).keyup(function (e) {

            input += e.which;

            clearTimeout(timer);

            timer = setTimeout(function() {
                input = '';
            }, 500);


            if( input == secret ) {
                // do stuff here
                if ( App.config.debug ) { console.log('konami code fired!'); }
            }
        })
    }


     /**
     * Helpers
     * Various helper functions for user agent detection and cross browser compatibility
     */
    App.helpers = {

        /**
         * isUserAgent
         * Determine the user agent via regex matching the string
         * @return {Boolean}
         */
        isUserAgent : function() {
            return {
                iOS         : (navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false),
                iphone      : (navigator.userAgent.match(/(iPhone|iPod)/g) ? true : false),
                ipad        : (navigator.userAgent.match(/(iPad)/g) ? true : false),
                android     : (navigator.userAgent.match(/(Android)/g) ? true : false),
                mobile      : ((/Mobile|iPhone|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ? true : false),
                mobile_all  : ((/Mobile|Android|iPhone|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ? true : false)
            }
        },

        /**
         * userAgentDetection
         * Perform actions if the user agent is a mobile device
         */
        userAgentDetection: function(){

            if ( App.helpers.isUserAgent().mobile ) {
                $('body').addClass('is_mobile');
            } else {
                $('body').addClass('non_mobile');
            }

        },

        /**
         * isBrowser
         * Determine the browser based on regex matching the navigator
         * @return {Boolean}
         */
        isBrowser: function() {
            return {
                desktop_chrome   : (window.chrome ? true : false),
                iphone_chrome    : ((navigator.userAgent.match(/(iPod|iPhone|iPad)/) && navigator.userAgent.match(/AppleWebKit/) && navigator.userAgent.match('CriOS')) ? true : false),
                iphone_safari    : ((navigator.userAgent.match(/(iPod|iPhone|iPad)/) && navigator.userAgent.match(/AppleWebKit/) && !navigator.userAgent.match('CriOS')) ? true : false),
                android_native   : (navigator.userAgent.indexOf('Android') > -1 && navigator.userAgent.indexOf('Mozilla/5.0') > -1 && navigator.userAgent.indexOf('AppleWebKit') > -1 && navigator.userAgent.indexOf('Chrome') <= -1),
                android_chrome   : (navigator.userAgent.indexOf('Android') > -1 && navigator.userAgent.indexOf('Mozilla/5.0') > -1 && navigator.userAgent.indexOf('AppleWebKit') > -1 && navigator.userAgent.indexOf('Chrome') > -1),
                android_samsung  : (navigator.userAgent.indexOf('Android') > -1 && navigator.userAgent.indexOf('Mozilla/5.0') > -1 && navigator.userAgent.indexOf('AppleWebKit') > -1 && navigator.userAgent.indexOf('Chrome') > -1 && navigator.userAgent.indexOf('SCH') > -1)
            }
        },

        /**
         * onLocationHash
         * Run a callback function when a string is the location hash
         * @param  {String}   hash_string
         * @param  {Function} callback
         */
        onLocationHash: function(hash_string, callback) {

            if( window.location.hash ) {
                var hash = window.location.hash.substring(1); 
                
                if ( hash === hash_string ) {
                    callback();
                }
            } else {
                return false;
            }
        },

        /**
         * preloadImages
         * Preload images by passing in array of url strings
         * @param  {Array} array
         */
        preloadImages: function(array, callback) {

            var promises = [];

            for ( var i = 0; i < array.length; i++ ) {
              (function (url, promise) {
                var img = new Image();

                img.onload = function() {
                  promise.resolve();
                };

                img.src = url;

                console.log('%cPreloaded', 'color:#4f89d1;', url);

              })(array[i], promises[i] = $.Deferred());
              
            }

            $.when.apply($, promises).done(function() {
              callback();
            });


        },


        /**
         * openSharePane
         * Open a small popup, used for social share windows
         * @param  {String} url
         */
        openSharePane: function(url) {
            window.open( url, "socialShareWindow", "status = 1, height = 500, width = 650, resizable = 0" );
        },


        /**
         * renderHTMLPartial
         * Render an HTML partial to a page (hacky, work-in-progress, do-not-ever-use-in-production)
         * @param  {String} file_path
         */
        renderHTMLPartial: function(file_path, target_id) {
            $.ajax({
                url: file_path,
                dataType: 'html'
            })
            .done(function (data) {
                console.log('%cIncluding partial', 'color:red', file_path);

                var html = data.split("\n").join("");

                document.getElementById(target_id).innerHTML = html;
            })
        },

        /**
         * animateScroll
         * Scroll the window to the target element
         * @param  {String} target
         * @param  {Integer} duration
         * @param  {Sting} easing
         * @param  {Integer} offset
         */
        animateScroll: function(target, duration, easing, offset) {
            if ( duration === 'auto' ) {
                duration = ((target.offset().top - $(window).scrollTop()) / 3.3 )
            }
            if( target ) {
                if(/(iPhone|iPod)\sOS\s6/.test(navigator.userAgent)){
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, duration, easing);
                } else {
                    $('html, body').animate({
                        scrollTop: target.offset().top - (offset)
                    }, duration, easing);
                }
            }
        },

        testFunc: function() {
            console.log(this);
        }
    }



    /**
     * DOCUMENT READY
     * -------------------------------------------------------------------
     *
     */
     $(document).ready(function(){


        App.init();



        // $(function() {
        //     //TWITTER FOLLOWER COUNT
        //     $.ajax({
        //         url: "https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names=<?php echo get_option('twitter_handle'); ?>",
        //         dataType : "jsonp",
        //         crossDomain : true
        //     }).done(function(data) {
        //         $(".twitter_count").html(data[0]['followers_count']);
        //     });
        //     //INSTAGRAM USER COUNT
        //     // https://instagram.com/oauth/authorize/?client_id=257e42116b554640a1d842f96c7bec73&redirect_uri=http://silencethegrowl.dev&response_type=token
        //     $.ajax({
        //         type: "GET",
        //         dataType: "jsonp",
        //         cache: true,
        //         url: "https://api.instagram.com/v1/users/145527455/?access_token=145527455.257e421.1cd164f2804244d58153d3caff0151ce",
        //         success: function(data) {
        //             var ig_count = data.data.counts.followed_by.toString();
        //             ig_count = add_commas(ig_count);
        //             $(".instagram_count").html(ig_count);
        //         }
        //     });
        //     function add_commas(number) {
        //         if (number.length > 3) {
        //             var mod = number.length % 3;
        //             var output = (mod > 0 ? (number.substring(0,mod)) : '');
        //             for (i=0 ; i < Math.floor(number.length / 3); i++) {
        //                 if ((mod == 0) && (i == 0)) {
        //                     output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
        //                 } else {
        //                     output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
        //                 }
        //             }
        //             return (output);
        //         } else {
        //             return number;
        //         }
        //     }
        // });
    }); //END DOCUMENT READY FUNCTION



    //ON WINDOW LOAD
    $(window).load(function(){

        //Always load at top of page

       
        //Add video to homepage
        //This is so it won't load on mobile and hopefully be super fast!
        if($(window).width() >= 768){
            //$('.bg-img').append('<video autoplay loop poster="//s3-us-west-2.amazonaws.com/uwd-assets/video-screenshot.jpg" id="bgvid" class="bg-video hidden-xs"><source src="//s3-us-west-2.amazonaws.com/uwd-assets/uwd-video-small.mp4" type="video/mp4"><source src="//s3-us-west-2.amazonaws.com/uwd-assets/uwd-video.ogv" type="video/ogv"><source src="//s3-us-west-2.amazonaws.com/uwd-assets/uwd-video.webm" type="video/webm"></video>');
        }


       //donately return messages
        function receiveMessage(event){
            try {var data = JSON.parse(event.data);}
            catch (e) {var data = event.data;}
            if(data.event == 'donately.loaded'){  
              console.log('donately form loaded');
            }
            if(data.event == 'donately.success'){
               // ga('send', 'event', 'donation', 'success');
            }
        }
        if (window.addEventListener){
            window.addEventListener('message', receiveMessage, false);
        }
        else if (window.attachEvent){
            window.attachEvent('message', receiveMessage);
        }

        $('.info').css({'padding-top': 200 + $(window).height() + 'px'});


    });



    $(window).scroll(function(){
        var documentScrollPercent = $(window).scrollTop() / ($(document).outerHeight() - $(window).height()),
            cornerPositionY = -(documentScrollPercent * 1100),
            cornerPositionX = -(documentScrollPercent * 240),
            currentCornerPositionX = parseInt($('.corner-inner').css('left')),
            currentCornerPositionY = parseInt($('.corner-inner').css('top')),
            currentBackpackPosition = parseInt($('#backpack_scroll').css('transform').split(',')[5]),
            backpackPosition = -(documentScrollPercent * 150),
            bottomOfInfo =  $('.info').offset().top + $('.info').outerHeight(),
            backpackScale = (1151 *  (1 - documentScrollPercent)) + 300;

            console.log(backpackScale);            

            if (bottomOfInfo > $(window).scrollTop()) { 
                animateCorner();
                scrollBackpack();

            //You've reached the bottom of the page
            } else {
                disable_scroll();
                shrinkBackpack();
            }
       
       
        //if($(window).scrollTop() > $(window).height()){
            
            //Move gray corner up    
            function animateCorner(){
                $('.corner').css({
                    'background-position-y': cornerPositionY,
                    'background-position-x': cornerPositionX
                });

                //fade
                $('.fade-content').css({'opacity': 1 - (documentScrollPercent*4)});

                 //content
                $('.corner-inner').css({
                    'top': -(documentScrollPercent) + currentCornerPositionY + 'px',
                    'left': -(documentScrollPercent) + currentCornerPositionX + 'px'

                });


               
            }

            //Scroll Backpack Up
            function scrollBackpack(){
                $('#backpack_scroll').css({
                    '-webkit-transform': 'translate3d(0,' + (backpackPosition) + 'px,0)',
                    '-moz-transform': 'translate3d(0,' + (backpackPosition) + 'px,0)',
                    '-ms-transform': 'translate3d(0,' + (backpackPosition) + 'px,0)',
                    '-o-transform': 'translate3d(0,' + (backpackPosition) + 'px,0)',
                    'transform': 'translate3d(0,' + (backpackPosition) + 'px,0)'

                });
            }

            //Scale Backpack down
            function shrinkBackpack(){
                $('#backpack_scroll img').css({
                    '-webkit-transform': 'scale(0.3)',
                    '-moz-transform': 'scale(0.3)',
                    '-ms-transform': 'scale(0.3)',
                    '-o-transform': 'scale(0.3)',
                    'transform': 'scale(0.3)'
                });
                $('#backpack_scroll').css({
                    'bottom': 0,
                    '-webkit-transform': 'translate3d(0, 0,0)',
                    '-moz-transform': 'translate3d(0, 0,0)',
                    '-ms-transform': 'translate3d(0, 0,0)',
                    '-o-transform': 'translate3d(0, 0,0)',
                    'transform': 'translate3d(0, 0,0)'
                });

                setTimeout(fadeInDonateForm, 1500);

                //setTimeout(slideUpFooter, 2500);
            }

            //Fade in donate form
            function fadeInDonateForm(){
                $('#donation').fadeIn();
                //enable_scroll();

            }

            function slideUpFooter(){
                $('footer').css({
                    '-webkit-transform': 'translateY(0)',
                    '-moz-transform': 'translateY(0)',
                    '-ms-transform': 'translateY(0)',
                    '-o-transform': 'translateY(0)',
                    'transform': 'translateY(0)'
                });
            }

            if (documentScrollPercent == 1) {
                
            }
          
        //};
    });

    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = [37, 38, 39, 40];

    function preventDefault(e) {
      e = e || window.event;
      if (e.preventDefault)
          e.preventDefault();
      e.returnValue = false;  
    }

    function keydown(e) {
        for (var i = keys.length; i--;) {
            if (e.keyCode === keys[i]) {
                preventDefault(e);
                return;
            }
        }
    }

    function wheel(e) {
      preventDefault(e);
    }

    function disable_scroll() {
      if (window.addEventListener) {
          window.addEventListener('DOMMouseScroll', wheel, false);
      }
      window.onmousewheel = document.onmousewheel = wheel;
      document.onkeydown = keydown;
    }

    function enable_scroll() {
        if (window.removeEventListener) {
            window.removeEventListener('DOMMouseScroll', wheel, false);
        }
        window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
    }

    //Force page reload to top of page
    $(window).on('beforeunload', function() {
       $(window).scrollTop(0);
    });



  

    /**
     * SELF INVOKING ANONYMOUS FUNCTION
     * -------------------------------------------------------------------
     * 
     */

    (function() { 

   

    })();




    /**
     * WINDOW RESIZE
     * -------------------------------------------------------------------
     *
     */
    $(window).resize(function(){   
        
 

    }).trigger('resize');



    /**
     * MATCH MEDIA
     * -------------------------------------------------------------------
     *
     */
    var mq_widescreen = window.matchMedia('only screen and (min-width:'+App.config.media_queries.widescreen+'px)');

    mq_widescreen.addListener(function (mql) {
        


    });



    /**
     * ORIENTATION CHANGE (requires jQuery mobile)
     * -------------------------------------------------------------------
     *
     */
    window.addEventListener("orientationchange", function() {
        
        

    }, false);





    

})(jQuery);
};



