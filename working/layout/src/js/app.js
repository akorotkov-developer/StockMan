;
$(document).foundation();

(function($) {
  "use strict";
  $(function() {
    //begin of .size visibility hidden/visible
    function checkHeaderAndHideSizeBlock() {
      if ($(window).scrollTop() > 0 ) {
        $('.size').addClass('js-invisible');
      } else {
        $('.size').removeClass('js-invisible');

      }
    }
    $(document).on('scroll', function() {
      checkHeaderAndHideSizeBlock();


    });
    $(window).on('load', function() {
      checkHeaderAndHideSizeBlock();


    });
    //end of .size visibility hidden/visible

    //begin of .sort click function
    $('.sort__main').click(function() {

      if ($(this).closest('.sort').hasClass('js-open')) {

        $('.sort.js-open').removeClass('js-open');

      } else {
        $('.sort.js-open').removeClass('js-open');
        $(this).closest('.sort').addClass('js-open');

      }

    });
    $('.js-apply').click(function() {
      $(this).closest('.sort').removeClass('js-open');
    });
    $('.js-select-all').click(function() {
      var $checkBoxes = $(this).closest('.sort').find('input');
      $checkBoxes.prop('checked', !$checkBoxes.prop('checked'));
    });
    $(document).mouseup(function(e) {
      var div = $(".sort.js-open");
      if (!div.is(e.target) && div.has(e.target).length === 0) {
        div.removeClass('js-open');
      }
    });
    //end of .sort click function
    //begin of fix .reveal_my close
    $('.reveal_my .close-button').click(function() {

      $('body,html').removeClass('is-reveal-open');
    });
    //end of fix .reveal_my close

    /**
     * Разные карусели
     */
    $(".sale").slick({
      infinite: true,
      dots: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
    });
    $(".map").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
        }
      }, {
        breakpoint: 800,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }]
    });
    $(".girl").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 7,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
        }
      }, {
        breakpoint: 800,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }]
    });
    //begin of .skirt__slider


    var imgUrl = [];
    $('.skirt__inner').each(function(index) {
      imgUrl.push($(this).find('img').prop('src'));

      $('.pants').append('<div><img src="' + imgUrl[index] + '" alt="" /></div>');

    });
    $('.pants').on('init', function(event, slick) {
      $('.pants .slick-dots li').each(function(index) {

        $(this).find('button').prop('style', 'background-image:url(' + imgUrl[index] + ');');

      });
      var heightDots = $('.pants .slick-dots').height();
      $('.pants .slick-next').css('top', heightDots + 100);
    });
    $(".pants").slick({
      infinite: true,
      dots: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: true,
      swipeToSlide: false,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {

        }
      }, {
        breakpoint: 800,
        settings: {

        }
      }, {
        breakpoint: 480,
        settings: {

        }
      }]
    });



    $(".skirt__slider").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
        }
      }, {
        breakpoint: 800,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }]
    });
    $('.skirt__prev').click(function() {
      $('.skirt__slider').slick('slickPrev');
    });
    $('.skirt__next').click(function() {
      $('.skirt__slider').slick('slickNext');
    });
    //end of .skirt__slider
    $(".x-carousel-services").slick({
      infinite: true,
      dots: true,
      arrows: false,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true
    });

    $(".x-carousel-news").slick({
      infinite: true,
      arrows: false,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: true,
      swipeToSlide: true,
      autoplay: true,
      autoplaySpeed: 7000,
      autoplayHoverPause: true
    });

    //begin of jquery-zoom plugin
    // $(document).ready(function() {
    //   $('.skirt__inner').each(function() {
    //     var imgUrl = $(this).data('img');
    //     $(this).zoom({
    //       url: imgUrl
    //     });
    //   });
    //
    // });
    // $('.skirt__slider').on('afterChange',function(slick,currentSlide) {
    //   $('.skirt__inner').each(function() {
    //      $('.fancybox').fancybox();
    //   });
    // });
    //end of jquery-zoom plugin
    $('.x-carousel-news-link').on('click', function(e) {

      e.preventDefault();
      var $this = $(this),
        index = $this.closest('.x-carousel-news-links').find('.x-carousel-news-link').index($this);
      $('.x-carousel-news').slick('slickGoTo', index);
    });


    /**
     * Показ любого блока по наведению на другой
     */
    var $linkThis;
    var toggleLeaveTimer;
    $('[data-toggle-hover-dd]').on('mouseenter mouseleave', function(e) {
      $linkThis = $(this);
      var selector = '#' + $(this).data('toggle-hover-dd');
      if ($(selector).length > 0) {
        var $toggler = $(selector);
        var className = $toggler.data('toggler-hover-dd');
        if (e.type == 'mouseenter' && !$toggler.hasClass(className)) {
          $toggler.addClass(className);
          $linkThis.addClass('menu-base__link_active');

        }
        if (e.type == 'mouseleave' && $toggler.hasClass(className)) {
          toggleLeaveTimer = setTimeout(function() {
            $toggler.removeClass(className);
            $linkThis.removeClass('menu-base__link_active');

          }, 300);
        }
      }
    });
    $('[data-toggler-hover-dd]').on('mouseenter', function() {
      var link = $(this).prop('id');
      $linkThis = $('[data-toggle-hover-dd=' + link + ']');


      clearTimeout(toggleLeaveTimer);
    }).on('mouseleave', function() {

      var $toggler = $(this);

      $linkThis.removeClass('menu-base__link_active');
      var className = $toggler.data('toggler-hover-dd');
      if ($toggler.hasClass(className)) {
        toggleLeaveTimer = setTimeout(function() {
          $toggler.removeClass(className)
        }, 300);
      }
    });

  });
})(jQuery);
