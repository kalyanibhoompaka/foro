(function(){
  'use strict';

  var menuTriggers, menuDrawer, menuDrawerContent;
  var visible = false;
  var transitioning = false;
  var transitionTime = 800; // Ms

  document.addEventListener("DOMContentLoaded", initMainNavigation );

  function initMainNavigation(){
    menuDrawer = document.querySelector('.c-main-menu-drawer');
    menuTriggers = document.querySelectorAll('.js-menu-trigger');
    for (var i = 0; i < menuTriggers.length; i++) {
      menuTriggers[i].addEventListener( 'click', toggleMainMenu );
    }
  }

  function toggleMainMenu( event ){
    // event.preventDefault();

    if(transitioning) {
      return;
    }

    if( visible ){
      hideMenu();
    }
    else{
      showMenu();
    }
  }

  function showMenu(){
    transitioning = true;
    menuDrawer.className = 'c-main-menu-drawer is-visible';

    setTimeout(function () {
      menuDrawer.className = 'c-main-menu-drawer is-visible is-active';
      visible = true;
    }, 50 );

    setTimeout(function () {
      transitioning = false;
    }, transitionTime);
  }

  function hideMenu(){
    transitioning = true;
    menuDrawer.className = 'c-main-menu-drawer is-visible';

    setTimeout(function () {
      menuDrawer.className = 'c-main-menu-drawer';
      visible = false;
      transitioning = false;
    }, transitionTime);
  }

  document.addEventListener('click', function(e){
    if (e.target != document.querySelector(".c-main-menu-drawer__content") && document.querySelector(".c-main-menu-drawer").classList.contains('is-active')) {
      toggleMainMenu();
    }
  })

})();
