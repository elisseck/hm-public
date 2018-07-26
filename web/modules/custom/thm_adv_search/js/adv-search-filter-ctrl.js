(function($, Drupal) {
    'use strict';

    Drupal.thm = Drupal.thm || {};

    Drupal.behaviors.searchFilters = {
        attach: function searchFilters(context, settings) {
            Drupal.thm.handleSearchFilters(context, settings);
        }
    };

    Drupal.thm.handleSearchFilters = function(context, settings) {
        $('.filters__button, .closeFilter').on('click', function(evt){
          $('.filters').toggleClass('open');
          $("body").toggleClass('overflowHidden');
        });
    };

})(jQuery, Drupal);