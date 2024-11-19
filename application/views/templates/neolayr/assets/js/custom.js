$(window).on("load resize",function() {
 var highestBox = 0;
        $('.slide.slick-slide').each(function(){  
                if($(this).height() > highestBox){  
                highestBox = $(this).height();  
        }
    });   
    $('.slick-track').height(highestBox);
});
$(document).ready(function() {
    $('.add_address_profile').click(function(event) {
       document.getElementById('add_address_profiles').scrollIntoView();
    });
    $('.edit_personalInfo').click(function(event) {
       document.getElementById('edit_personalInfos').scrollIntoView();
    });
    /*************************************************/
    $('.previous-one').click(function(){
        $('.step-one').show();
        $('.step-two').hide();
        $('.select_concern').hide();
    })
    $('.previous-two').click(function(){
        $('.step-three').hide();
        $('.step-two').show();
        $('.each-screen').removeClass('active');
        $('.with-out-select-three, .with-out-select-two, .with-out-select-one').show();
        $('.go-third-step, .go-forth-step, .go-fifth-step').hide();

    })
    $('.each-form-field button.greay').click(function(){       
        $('.each-screen').removeClass('active');
        $('.with-out-select-three, .with-out-select-two, .with-out-select-one').show();
        $('.go-third-step, .go-forth-step, .go-fifth-step').hide();
        $('.sktp').removeClass('is-sk');

    })
    $('.previous-three').click(function(){
        $('.step-three').show();
         $('.step-four').hide();
         $('.last-step').removeClass('is-sk');
         $('.last-step').removeClass('sktp');
         $('#nsk').val('Select Your Skin Type');
         $('.IsSkin').hide();
         $('.SkinType').hide();
         $('.IsSkin').removeClass('force-hide');
         $('.SkinType').removeClass('force-hide');
    })
        /****************************************/
    
    /**********************************************/
    $('.use-address').click(function(){
        $('.use-this-address').hide();
        $('.address-list-area').hide(300);
    })
    $('.ad-wish').click(function(){
        $('.hide-signup').hide();
        $('.add-new-message').hide();
        $('.if-errow').show();
    })
    $('.hide-signup').click(function(){
        $('.f-login').show();
       // $('.address-list-area').hide(300);
    })
    $('#select-a-delivery-address').click(function(){           
        $('.use-this-address').toggle();
        $('.address-list-area').toggle(300);
    })
    $('#open-coupon-code').click(function(){            
        $('#coupon-body').slideToggle();            
    })
    $('#redeem-reward').click(function(){           
        $('#reedem-body').slideToggle();            
    })
    $('#gift-card').click(function(){           
        $('#gift-card-body').slideToggle();            
    })
    /**********************************************/
    $('.comment-text').click(function(){
        $(this).parents('.invoice-product').find('.comment-box').show(300);
    })
    $('.cancel-review').click(function(){
        $(this).parents('.invoice-product').find('.comment-box').hide(300);
    })
    $('.each-screen').click(function(){
        //$(this).parents('.skin-concern').find('.each-screen').removeClass('active');
        $('.quiz_products_list').css('display','block');
        $(this).parents('.skin-concern').find('.each-screen').removeClass('active');
        $(this).addClass('active');
    })
    // $('.each-screen').click(function(){
    //     $(this).parents('.skin-concern').find('.each-screen').removeClass('active');
    //     $(this).addClass('active');
    // })
    $('.go-third-step').click(function(){
        $('.step-two').hide();
        $('.step-three').show();
    })
    $('.go-forth-step').click(function(){ 
        $('.step-three').hide();
        if($("#skin_concern_name").val() == "hair-fall")
        {
            $('.go-fifth-step').trigger("click");
            $('.skin-type, .skin').parent("h3").hide();
        }
        else
        {
            $('.step-four').show();
        }
    })
    $('.go-fifth-step').click(function(){
        $('.step-four').hide();
        $('.fifte-step').show();
        $('.all-qz').hide();
    })
    $('.st-top-part-close').click(function(){
        $('.step-one').show();
        $('.all-qz').show();
        $('.fifte-step').hide();
        $('.each-screen').removeClass('active');
        $('.with-out-select-three, .with-out-select-two, .with-out-select-one').show();
        $('.go-third-step, .go-forth-step, .go-fifth-step').hide();
        $('.last-step').removeClass('is-sk');
    })
    
    $('.qz-step-first').click(function(){
        var this_text = $(this).find('.first-sk-name').text();
        var screen_type = $(this).attr('data_screen');
        $('.concern').text(this_text).show();
        $('.with-out-select-one').hide();
        $('.go-third-step').show();
        $('.common-sc-screen').hide();
        $('.'+screen_type).show();
    })
    $('.qz-step-sccond').click(function(){
        var second_text = $(this).find('.sk-big').text();
        $('.specified').text(second_text);
        $('.go-forth-step').show();
        $('.with-out-select-two').hide();
    })
    $('.qz-step-third').click(function(){
         $('#nsk').val('Select Your Is Skin')
        var third_text = $(this).find('.sk-big').text();
        $('.skin-type').text(third_text);
        $('.skin-type').parent("h3").show();
        $('.last-step').addClass('sktp');
        
    })
    $('.qz-step-forth').click(function(){
        $('#nsk').val('Select Your Skin Type')
        var third_text = $(this).find('.sk-big').text();
        $('.skin').text(third_text);        
        $('.skin').parent("h3").show();
        $('.last-step').addClass('is-sk');
        $('.IsSkin').hide();
        $('.IsSkin').addClass('force-hide');
    })
    $('.quuiz-close').click(function(){        
        $('.quiz-message').removeClass('active');        
    })
    $('.with-out-select-one').click(function(){
        //alert('Please select a Concern');
        //$('.quiz-message').addClass('active');
        $('.select_concern').show();
        //$('.quiz-message-text').text('Please select a Concern')
    })
    $('.with-out-select-two').click(function(){
        //alert('Select Specified Concern');
        // $('.quiz-message').addClass('active');
        // $('.quiz-message-text').text('Select Specified Concern')
         $('.specifiedConcern').show();
    })
    $('.qz-step-forth').click(function(){
        $('#nsk').val('Select Your Skin Type')
        var third_text = $(this).find('.sk-big').text();
        $('.skin').text(third_text);        
        $('.skin').parent("h3").show();
        $('.last-step').addClass('is-sk');
    })
    $('.with-out-select-three').click(function(){
        //alert('Select Specified Concern');
        var nsk_message = $('#nsk').val();
        //$('.quiz-message').addClass('active');
        //$('.quiz-message-text').text(nsk_message);
        $('.SkinType').show();
        $('.IsSkin').show();
    })
    /**************************************/
    $('.open-before-apply').click(function(){
        $('.after-apply').hide();
        $('.before-apply').show();
    })
    $('.v-check').click(function(){
        $('.voucher-success').addClass('active');
    })
    $('.ad_select').click(function(){
        $('.ad_select').removeClass('selected');
        $(this).addClass('selected');
    })
    $('.mobile-search > a').click(function() {
        //$('.mobile-search-wrapper').slideToggle(250);
        $('.m-serch').toggleClass('active');
    });
    $('.on-product-wishlist').click(function() {
        $(this).addClass('active');
    })
    $('.product-category > li > a').click(function(event) {
        index = $(this).parent('li').index();
        //alert(index);
        $(this).parents('.shop-product').find('.product-sl-list .each-slide').removeClass('active');
        $(this).parents('.shop-product').find('.product-sl-list .each-slide').eq(index).addClass('active');
    });

    $('.each-location').click(function(event) {
        index = $(this).index();
        //alert(index);
        $(this).parents('.location-bottom').find('.map-area .each-map').removeClass('active');
        $(this).parents('.location-bottom').find('.map-area .each-map').eq(index).addClass('active');
    });
    $('.first-sign').click(function() {
        $('.f-login').hide();
        $('.otp-login').show();
    })
    const settings = {
        loop: true,
        //speed: 1000,
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".banner-next",
            prevEl: ".banner-prev"
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
        },
        effect: 'fade',
    };
    const swiper = new Swiper(".home-banner", settings);

    window.setTimeout(function() {
        $('.swiper-slide.swiper-slide-active .each-banner-image').show();
    }, 1000);

    /*********** PRODUCT CAT********** */
    $('.each-cat').click(function() {
        $('.each-cat').removeClass('active');
        $(this).addClass('active');
    })
    
    
    $('.each-location').click(function() {        
        $('.each-location').removeClass('active');
        $(this).addClass('active');
    })
    /**************SHOP PRODUCT ********** */
    // Swiper: Slider
    new Swiper('.product-slider.product-slider1', {
        loop: false,
        noSwiping: true,
        navigation: {
            nextEl: ".product-sl-list .product-next1",
            prevEl: ".product-sl-list .product-prev1"
        },
        allowTouchMove: false,
        //observer: true,
        //observeParents: true,
        slidesPerView: 2,
        paginationClickable: true,
        /*pagination: {
            el: '.swiper-pagination',
            clickable: true
        },*/
        spaceBetween: 5,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.product-slider.product-slider_pdetails', {
        loop: false,
        navigation: {
            nextEl: ".product-sl-list .product-next1",
            prevEl: ".product-sl-list .product-prev1"
        },
        //allowTouchMove: false,
        observer: true,
        observeParents: true,
        slidesPerView: 2,
        //paginationClickable: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        spaceBetween: 5,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.product-slider.product-slider2 ', {
        loop: false,
        navigation: {
            nextEl: ".product-sl-list .product-next2",
            prevEl: ".product-sl-list .product-prev2"
        },
        allowTouchMove: false,
        //observer: true,
        //observeParents: true,
        slidesPerView: 2,
        spaceBetween: 5,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.product-slider.product-slider3', {
        loop: false,
        navigation: {
            nextEl: ".product-sl-list .product-next3",
            prevEl: ".product-sl-list .product-prev3"
        },
        allowTouchMove: false,
        //observer: true,
        //observeParents: true,
        slidesPerView: 2,
        spaceBetween: 5,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });

    new Swiper('.related-product-slider', {
        loop: true,
        navigation: {
            nextEl: ".related-next",
            prevEl: ".related-prev"
        },
        observer: true,
        observeParents: true,
        slidesPerView: 4,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
    /********************* Concern Slider ********************/
    new Swiper('.concern-slider', {
        loop: true,
        navigation: {
            nextEl: ".concern-next",
            prevEl: ".concern-prev"
        },
        slidesPerView: 2.45,
        paginationClickable: true,
        spaceBetween: 5,
        breakpoints: {
            1400: {
                slidesPerView: 5,
                spaceBetween: 30
            },
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 2.5,
                spaceBetween: 10
            }
        }
    });
    /************************************ */
    new Swiper('.testimonial-slider', {
        loop: true,
        navigation: {
            nextEl: ".testimonial-next",
            prevEl: ".testimonial-prev"
        },
        pagination: {
            el: '.testimonial-pagination',
            clickable: true
        },
        slidesPerView: 4,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });

    new Swiper('.testimonial-slider-new', {
        loop: true,
        navigation: {
            nextEl: ".testimonial-next-new",
            prevEl: ".testimonial-prev-new"
        },
        pagination: {
            el: '.testimonial-pagination-new',
            clickable: true
        },
        slidesPerView: 4,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });

    /********************* Regime Slider ****************/
    new Swiper('.regime-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: false,
        navigation: {
            nextEl: ".regime-next",
            prevEl: ".regime-prev"
        },
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.blog-slider', {
        loop: true,
        navigation: {
            nextEl: ".blog-next",
            prevEl: ".blog-prev"
        },        
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 1.5,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 1.5,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.blog-slider-new', {
        //loop: true,
        navigation: {
            nextEl: ".blog-next",
            prevEl: ".blog-prev"
        },
        // centeredSlides:true,       
        slidesPerView: 4,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.location-slider', {
        loop: false,
        navigation: {
            nextEl: ".location-next",
            prevEl: ".location-prev"
        },        
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 1.5,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 1.5,
                spaceBetween: 10
            }
        }
    });
    /**************MENU ICON *************/
    $(".hamburger").click(function() {
        $(this).toggleClass("is-active");
        $('.menu-area').toggleClass("active");
        $('body').toggleClass("all-scroll-hide");
    });
    $('.when-already-login').click(function(){
        $(this).toggleClass('active');
    })
    $('.menu-area ul li.has-children > a').click(function(e) {
        $(this).attr("href", "javascript:void(0)")
        //$('.menu-area ul').removeClass('active');
        $(this).next('ul').toggleClass('active');
        $(this).closest('li').siblings().find('ul').removeClass('active')
    })
    /*$('.product-category-filter ul li.sub-filter a').click(function(e){
        $(this).attr("href","javascript:void(0)")
        //$('.category-panel').css('display' ,'none');
        $(this).next('div').slideToggle(250);
        $(this).closest('li').siblings().find('ul').removeClass('active')
    })*/

   /* $('.product-category-filter > ul li.main-filter > a ').click(function(e) {
        $(this).attr("href", "javascript:void(0)");
        $('.main-filter .category-panel').removeClass('active');
        $('.sub-filter .sub-category-panel').removeClass('active');
        $(this).next('div').addClass('active');
    })*/
    $('.main-filter > a').click(function(){
        //alert();
        $(this).parent('.main-filter').find('.category-panel').slideToggle();
        $(this).parent('.main-filter').toggleClass('close-sign');
    })
    $('li.sub-filter > a ').click(function(e) {
        $(this).attr("href", "javascript:void(0)");
        //$('.sub-filter .sub-category-panel').removeClass('active');
        $(this).next('div').slideToggle();
        $(this).parent('.sub-filter').toggleClass('close-sign');
    });
    $('.personal-info-detailed-content-left > ul > li.submenu > a').click(function() {
        $('.personal-info-detailed-content-left > ul > li.submenu ul').slideUp(250);
        $(this).closest('li').children('ul').slideToggle(250)
    });
    $('.m-serch').click(function() {
        $(this).addClass('active');
    })
    $(".fancybox").fancybox();
    $('[data-fancybox="images"]').fancybox({
        thumbs: {
            autoStart: true,
            axis: 'x'
        }
    })
    /*********************************************************/
    var sections = $('.each-big-p'),
        nav = $('.thumb-area ul')
        //, //nav_height = nav.outerHeight();
        ,
        nav_height = $('.site-header').height();

    $(window).scroll(function() {
        var cur_pos = $(this).scrollTop();

        sections.each(function() {
            var top = $(this).offset().top - nav_height - 80,
                bottom = top + $(this).outerHeight();

            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('a').removeClass('active');
                sections.removeClass('active');

                $(this).addClass('active');
                nav.find('a[href="#' + $(this).attr('id') + '"]').addClass('active');
            }
        });
    });

    nav.find('a').click(function() {
        var $el = $(this),
            id = $el.attr('href');

        $('html, body').animate({
            scrollTop: $(id).offset().top - nav_height
        }, 500);

        return false;
    });
    /*********************************************************/
    /************************* QUANTITLY*******************/
    var incrementPlus;
    var incrementMinus;

    var buttonPlus = $(".cart-qty-plus");
    var buttonMinus = $(".cart-qty-minus");

    var incrementPlus = buttonPlus.click(function() {
        var $n = $(this).parent("div").parent(".button-container").find(".qty");
        $n.val(Number($n.val()) + 1);
        var currentVal = parseInt($n.val());
        $('#product_qty').val(currentVal);
        //console.log("currentVal", currentVal);
    });

    var incrementMinus = buttonMinus.click(function() {
        var $n = $(this).parent("div").parent(".button-container").find(".qty");
        var amount = Number($n.val());
        if (amount > 1) {
            $n.val(amount - 1);
        }
        var currentVal = parseInt($n.val());
        $('#product_qty').val(currentVal);
        //console.log("currentVal", currentVal);
    });
    /***************************************/
    $('.open-otp-box').click(function() {
        $('.open-otp').slideToggle();
    })
});

// $('.product-add-to-cart .common-button').click(function(){
//     $(this).text('Go To Cart');
//     $(this).addClass('active');
// });
// $('.product-price-and-description > a').click(function(){
//     $(this).text('Go To Cart');
//     $(this).addClass('active');
// });

/*$('.main-carousel').flickity({
  // options
  cellAlign: 'left',
  contain: true
});*/

// $('#otpVerify').click(function() {
//     $('.login-successfully-message').addClass('active');
// })

/*$('#registration').click(function() {
    $('.regiter-message').addClass('active');
})*/
$(function(){
        $('#registration').on("click", function () {
        $('.regiter-message').addClass("active");
        setTimeout(RemoveClass, 1700);
        });
        function RemoveClass() {
        $('.regiter-message').removeClass("active");
        }
}); 
$(function(){
        $('#otpVerify').on("click", function () {
        $('.login-message').addClass("active");
        //setTimeout(RemoveClass, 1700);
        });
        function RemoveClass() {
        $('.login-message').removeClass("active");
        }
});

// $(function(){
//         $('#add_consultation').on("click", function () {
//         console.log("ok");
//         $('.consultation-message').addClass("active");
//         setTimeout(RemoveClass, 1700);
//         });
//         function RemoveClass() {
//         $('.consultation-message').removeClass("active");
//         }
// });

$(document).ready(function() {
    $("body").tooltip({
        selector: '[data-toggle=tooltip]'
    });
});
$('.wishlist-img').click(function() {
    $(this).toggleClass('active');
    //$('.wishlist-popup').addClass('active');
    $('.wishlist-popup').addClass('active')
})
$('.category-select-list a').click(function() {
    $(this).hide();
})
// setTimeout(function(){
//     $('.wishlist-popup').removeClass('active');
// },3000);
$('.scroll_storeLocators').on('click', function(e) {
    $('html, body').animate({
    scrollTop: $('#scorll-hear').offset().top - 120 //#DIV_ID is an example. Use the id of your destination on the page
    }, 2000);
});

setTimeout(function(){
    $('.wishlist-img').click(function() {
        $('.wishlist-popup').addClass('active').removeClass('active');
    })    
},1000);

$('.scroll_skin_quiz').on('click', function(e) {
    $('html, body').animate({
    scrollTop: $('#skin_quiz').offset().top - 120 //#DIV_ID is an example. Use the id of your destination on the page
    }, 2000);
});
new Swiper ('.slider', {    
    slidesPerView: 1,
    loop: false,  
    pagination: {
        el: '.swiper-pagination-new',
        clickable: true
    },
});

$('.single-item').slick({ 
    autoplay: false,
    autoplaySpeed: 600,
    arrows: false,
    slidesToShow: 1,
    slidesToScroll: 1
  });
$('.single-item').mouseover(function() {
  $(this).slick('play')
});
$('.single-item').mouseout(function() {
  $(this).slick('pause')
});
const settingss = {
        loop: true,
        //speed: 1000,
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".banner-next",
            prevEl: ".banner-prev"
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
        }
    };
    const swiper = new Swiper(".aboutUs-banner", settingss);

    new Swiper('.review-video-banner .swiper-container', {
        loop: false,
        /*noSwiping: true,*/
        navigation: {
            nextEl: ".review-video-banner .review-video-next",
            prevEl: ".review-video-banner .review-video-prev"
        },
        allowTouchMove: false,
        //observer: true,
        //observeParents: true,
        slidesPerView: 1.25,
        /*paginationClickable: true,*/
        /*pagination: {
            el: '.swiper-pagination',
            clickable: true
        },*/
        spaceBetween: 5,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            480: {
                slidesPerView: 1.25,
                spaceBetween: 10
            }
        }
    });
    new Swiper('.frequently-bought-slider', {
        //loop: true,
        navigation: {
            nextEl: ".frequently-bought-next",
            prevEl: ".frequently-bought-prev"
        },
        // centeredSlides:true,       
        slidesPerView: 4,
        paginationClickable: true,
        spaceBetween: 20,
        breakpoints: {
            1300: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });