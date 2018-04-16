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

$(function() {
  makeFooterStayBelow();

  $( window ).resize(function() {
    makeFooterStayBelow();
  });
});