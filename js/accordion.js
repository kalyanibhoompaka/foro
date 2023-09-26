(function ($) {
  'use strict';

  Drupal.behaviors.foropaeAccordion = {
    attach: function (context, settings) {
      $('.js-speaker-trigger, .js-dropdown-trigger', context).once('init-accordion').bind('click', function(e){
        var $accordion = $(this).parent().parent();
        var $group = $accordion.parent();

        $group.find('.field--item').each( function(){
          console.log( this, $(this).children()[0] );
          if($accordion.find('div.p-dropdown').length !== 0) {
            if( $accordion[0] !== this ){
              var $sibling = $(this);
              if( $sibling.find('div.p-dropdown').hasClass('is-expanded') ){
                $sibling.find('.c-speaker-card__more, .p-dropdown__content').slideUp('fast');
                $sibling.find('div.p-dropdown').removeClass('is-expanded');
              }
            }
          }
        });
        if( !$accordion.find('div.p-dropdown').hasClass('is-expanded') ){
          $accordion.find('.c-speaker-card__more, .p-dropdown__content').slideDown('fast');
          $accordion.find('div.p-dropdown').addClass('is-expanded');
        }else{
          $accordion.find('.c-speaker-card__more, .p-dropdown__content').slideUp('fast');
          $accordion.find('div.p-dropdown').removeClass('is-expanded');
        }

        e.preventDefault();
      });
    }
  };

})(jQuery);
