(function($, Drupal) {
    'use strict';

    Drupal.thm = Drupal.thm || {};

    Drupal.behaviors.searchFilters = {
        attach: function searchFilters(context, settings) {
            Drupal.thm.handleSearchFilters(context, settings);
        }
    };

    Drupal.thm.handleSearchFilters = function(context, settings) {
        $('.facets__button').once('search-facets-toggle').on('click', function(evt){
          Drupal.thm.toggleClasses();
        });

        $('.facets__header-button').once('search-facets-cancel').on('click', function (evt) {
          Drupal.thm.toggleClasses();
        })
    };

    Drupal.thm.toggleClasses = function() {
      $('.block-thm-adv-search-facet-container').toggleClass('open');
      $('body').toggleClass('overflowHidden');
    };

})(jQuery, Drupal);
