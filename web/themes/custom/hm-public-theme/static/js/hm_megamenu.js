var megamenuUtils = function(){
  var $hamburger = $( ".header__hamburger" );
  var $megamenu = $( "#hm-public-theme-main-menu" );
  var $menu = $( ".menu.menu--simple-mega-menu" );
  var $spans = $( ".accordion__arrow" );


  var closeNavigation = function(){
    $megamenu.removeClass( "open" );
    $( ".header__hamburger.open" ).addClass("show");
    $( ".header__hamburger.close" ).removeClass("show");
  }

  var openNavigation = function(){
    $megamenu.addClass( "open" );
    $( ".header__hamburger.open" ).removeClass("show");
    $( ".header__hamburger.close" ).addClass("show");
  }

  //default
  closeNavigation();

  $hamburger.on( "click", function(e){
    if( !$megamenu.hasClass("open") ){
      openNavigation();
    }else{
      closeNavigation();
    }

    e.stopPropagation();
  });

  $(window).click(function() {
    closeNavigation();

    $spans.each( function(i, span){
      $(span).parent().removeClass( "show" );
    });
  });

  $spans.on( "click", function(e){
    var $thisSpan = $(this);
    var $parent = $thisSpan.parent();

    if( !$parent.hasClass("show") ){
      $parent.addClass("show");
    }else{
      $parent.removeClass("show");
    }

    //close other menus
    $spans.each( function(i, span){
      var $span = $(span);
      if( $span[0] != $thisSpan[0] ){
        $span.parent().removeClass( "show" );
      }
    });

    e.stopPropagation();
  });

  var onResize = function(){
    if( $(document).width() > 1247 ){
      $spans.each( function(i, span){
        $(span).parent().removeClass( "show" );
      });

      closeNavigation();
    }
  }

  $( window ).resize( onResize );
  onResize();

  //append footer menu items into header menu
  var $footerMenuItems = $("footer .menu" ).children();
  var $footerLi;
  $.each($footerMenuItems, function(i,li){
    $footerLi = $(li).clone();

    //class helps to keep these menu items visible only in smartphone
    $footerLi.addClass("footer-menu-item");
    $menu.append( $footerLi );
  })

  //append logo at navigation
  var $headerLogo = $("header .header__logo-container");
  $megamenu.prepend( $headerLogo.clone() );
}

$(function() {
  megamenuUtils();
});