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

var $scrollButton = document.querySelector('.scroll');
function scrollStep() {
    // Check if we're at the top already.
    window.scrollTo(0, 0);
}

if( $scrollButton ){
  $scrollButton.addEventListener('click', scrollStep);
}

//timeline js
$(function(){
  function getUrlVars()
  {
      var vars = [], hash;
      var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
      {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
      }
      return vars;
  }
  var year = getUrlVars()["year"];
  var month = getUrlVars()["month"];
  var day = getUrlVars()["day"];
    $('#edit-year').val(year); $('#edit-month').val(month); $('#edit-day').val(day);
});

$(function() {
    $('.filters__button').click(function(){
    $('.filters').toggleClass('open');
  });
})