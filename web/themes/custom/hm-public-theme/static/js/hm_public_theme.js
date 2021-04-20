(function ($, Drupal, window, document, undefined) {

    Drupal.thm = Drupal.thm || {};

    Drupal.behaviors.hm_public_theme = {
        attach: function (context, settings) {

            var constants = Drupal.behaviors.fortytwoMain.constants;

            // Store responsive type
            var body = $('body');
            if (body.hasClass('layout-adaptive')) {
                constants.LAYOUT = {
                fluid: false,
                adaptive: true
                };
            }
            else if (body.hasClass('layout-fluid')) {
                constants.LAYOUT = {
                fluid: true,
                adaptive: false
                };
            }

            if (settings.path.currentPath === 'advanced-search') {
                Drupal.thm.handleFilterReset(context, settings);
            }

            Drupal.thm.searchToggler(context, settings);
        }
    };

    Drupal.thm.handleFilterReset = function(context, settings) {
        var containerCls = '.thm-adv-search-filter-mgmt',
            targetId     = '#filter-reset',
            path         = settings.path,
            location     = window.location;

        $(containerCls).find(targetId).once('handle-filters')
          .on('click', function(evt) {
            evt.preventDefault();
            location.replace(path.baseUrl + path.currentPath);
          });
    };

    //Global search function

    function elementIsVisible(ele) {
      return window.getComputedStyle(ele, null).getPropertyValue('display') !== 'none';
    }

    Drupal.thm.searchToggler = function(context, settings) {
        var $containers = ['.header__top-row '],
            targetCls   = '.header__search',
            formCls     = '.search-form';

        if (!elementIsVisible(document.querySelector($containers[0]))) {
          $('.header__bottom-row').find(targetCls).once('mobile-search')
            .on('click', function(evt) {
              $('.header__bottom-row ' + formCls).fadeToggle();

              $(".header__search-close").removeClass("mobile-hide");
              $(".header__search").addClass("mobile-hide");
            })

          //Mobile close search icon is selected to close form
          $('.header__search-close').click(function() {

            $('.header__bottom-row ' + formCls).fadeToggle();
            $(".header__search").removeClass("mobile-hide");
            $(".header__search-close").addClass("mobile-hide");
          });
        } else {
          $($containers.join(',')).find(targetCls).once('toggle-search').each(function () {
            //Desktop search icon is selected to open form
            $(this).on('click', function (evt) {
              var $desktopForm = $containers[0] + formCls;
              $($desktopForm).fadeToggle();

              $(".header__search-close").removeClass("hide");
              $(".header__search").addClass("hide");
            });

            //Desktop close search icon is selected to close form
            $('.header__search-close').click(function() {
              var $desktopForm = $containers[0] + formCls;

              $($desktopForm).fadeToggle();
              $(".header__search").removeClass("hide");
              $(".header__search-close").addClass("hide");
            });

          });
        }
    };

  //End global search function



  //Open accordions
  $(".accordion__panel").removeClass("collapsed");
  $(".accordion__body").addClass("show");



})(jQuery, Drupal, this, this.document);

$('.carousel').carousel({
  interval: 9000
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
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
    });
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
    $('.filters__button, .closeFilter').click(function(){
      $('.filters').toggleClass('open');
      $("body").toggleClass('overflowHidden');;
    });
});

//for glossary mobile menu

$(document).ready(function(){
  if($("body").hasClass("path-glossary")==true){
    var p = $( ".timeline_cont.glossary" );
    var offset = p.offset();
    offset=offset.top;
    if($(document).width() <= 769){
      $(window).scroll(function () {
        curSP=$(document).scrollTop();
        if(curSP > offset){
          $(".pages").addClass("fixed");
        }else{
          $(".pages").removeClass("fixed");
        }
      });
    }
    $(window).resize(function() {
      if($(document).width() <= 769){
      $(window).scroll(function () {
        curSP=$(document).scrollTop();
        if(curSP > offset){
          $(".pages").addClass("fixed");
        }else{
          $(".pages").removeClass("fixed");
        }
      });
     }
    });
  }
});

