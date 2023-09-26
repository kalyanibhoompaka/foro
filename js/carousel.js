(function ($) {
  'use strict';

  Drupal.behaviors.foropaeCarousel = {
    attach: function (context, settings) {
      setTimeout(function () {
        $('.js-owl-carousel', context).owlCarousel({
            margin:0,
            loop:true,
            items:1,
            nav: false,
            dots: true,
            dotsData: true,
            navText: [
              '<span class="o-nav-arrow"></span>',
              '<span class="o-nav-arrow"></span>'
            ],
        });
      }, 10);

    }
  };

})(jQuery);
