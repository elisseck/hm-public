(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.hm_public_theme = {
    attach: function (context, settings) {
      constants = Drupal.behaviors.fortytwoMain.constants;

      // Store responsive type
      var body = $('body');
      if (body.hasClass('layout-adaptive')) {
        constants.LAYOUT = {
          fluid: false,
          adaptive: true,
        };
      }
      else if (body.hasClass('layout-fluid')) {
        constants.LAYOUT = {
          fluid: true,
          adaptive: false,
        };
      }
    },
  };

})(jQuery, Drupal, this, this.document);

$('.carousel').carousel({
  interval: 5000,
  pause: "true"
});

$(window).scroll(function() {
});
$('#return-to-top').click(function() {      // When arrow is clicked
  $('body,html').animate({
      scrollTop : 0                       // Scroll to top of body
  }, 500);
});

const $scrollButton = document.querySelector('.scroll');
function scrollStep() {
    // Check if we're at the top already.
    window.scrollTo(0, 0);
}

if( $scrollButton ){
  $scrollButton.addEventListener('click', scrollStep);
}

var makeFooterStayBelow = function(){

  var $canvas = $(".dialog-off-canvas-main-canvas").eq(0);
  var $content = $( '.content-wrapper').eq(0);

  $content.attr( "style", "min-height:''");

  $content.height( "auto" );
  $canvas.height("auto");

  //sometimes content can be too short..
  var diff = $(document).height() - $canvas.height();

  if( diff > 0 ) {
    $content.attr( "style", "min-height:" + ($content.height() + diff) + "px");
  }
};


var megamenuUtils = function(){
  var $megamenu = $( ".menu.menu--simple-mega-menu" );
  var $spans = $( "span", $megamenu );


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
  }).focusout(  function(){
    console.log( "blur me");
    var $thisSpan = $(this);
    var $parent = $thisSpan.parent();
    $parent.removeClass("show");
  });

  var onResize = function(){
    if( $(document).width() > 1247 ){
      $spans.each( function(i, span){
        $(span).parent().removeClass( "show" );
      });
    }
  }

  $( window ).resize( onResize );
  onResize();
}

$(function() {
  makeFooterStayBelow();
  megamenuUtils();

  $( window ).resize(function() {
    makeFooterStayBelow();
  });
});