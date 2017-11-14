;
$(document).foundation();

(function($) {
  "use strict";
  $(function() {
    //begin of .sort click function
    $('.sort').click(function() {
      if ($(this).hasClass('js-open')) {

        $('.sort.js-open').removeClass('js-open');
      } else {
        $('.sort.js-open').removeClass('js-open');
        $(this).addClass('js-open');

      }

    });
    //end of .sort click function

    /**
     * Разные карусели
     */
    $(".sale").slick({
      infinite: true,
      dots: false,
      arrows: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
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
