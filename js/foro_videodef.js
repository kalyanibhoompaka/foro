(function ($) {

    'use strict';
  
    Drupal.behaviors.foroVideoDeferred = {
  
      attach: function (context, settings) {
  
        // New video support for Youtube in FOROPAE using paragraphs
        $('a', context).each( function(){
          var $link = $(this);
          var href = $link.attr("href");
          var id = ytVidId( href );
  
          if( id ){
            $link.unbind();
            $link.addClass('js-video external-link-popup-disabled');
            $link.bind('click', videoLinkClickHandler );
          }
  
        });
  
      }
  
    };
  
    function videoLinkClickHandler( event ){
  
      var $link = $( this );
      var id = ytVidId( $link.attr("href") );
  
      if( id ){
        event.preventDefault();
        var markup = getYoutubeMarkup( id );
        showModal( markup );
      }
    }
  
    /**
     * JavaScript function to match (and return) the video Id
     * of any valid Youtube Url, given as input string.
     * @author: Stephan Schmitz <eyecatchup@gmail.com>
     * @url: https://stackoverflow.com/a/10315969/624466
     */
    function ytVidId( url ) {
      if( !url ) return false;
      
      var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      return (url.match(p)) ? RegExp.$1 : false;
    }
  
    function getYoutubeMarkup( id ){
      var ytParams = '?autoplay=1&autohide=2&color=white&border=0&wmode=opaque&enablejsapi=1&controls=1&showinfo=0&rel=0'
      var iframe = document.createElement("iframe");
      iframe.setAttribute('src', '//www.youtube.com/embed/'+ id + ytParams );
      iframe.setAttribute('frameborder', '0');
      iframe.setAttribute('allowfullscreen', true);
  
      var wrapper = document.createElement( 'div' );
      wrapper.classList.add( 'aspect-16-9' );
      wrapper.appendChild( iframe );
  
      return wrapper;
    }
  
    function showModal( content ){
      var modal = document.createElement( 'div' );
      modal.classList.add( 'c-modal-video' );
      modal.addEventListener( 'click', closeModal);
  
      var modalContainer = document.createElement( 'div' );
      modalContainer.classList.add( 'c-modal-video__content' );
      modalContainer.appendChild( content );
      modal.appendChild( modalContainer );
  
      var close =  document.createElement( 'div' );
      close.classList.add( 'c-modal-video__close' );
      close.addEventListener( 'click', closeModal);
      modal.appendChild( close );
  
      document.body.appendChild( modal );
    }
  
    function closeModal(){
      $('.c-modal-video').remove();
    }
  
  }(jQuery));
  