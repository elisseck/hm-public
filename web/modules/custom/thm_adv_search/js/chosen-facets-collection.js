
(function ($, _, Drupal) {
    'use strict';

    Drupal.thm = Drupal.thm || {};
    Drupal.behaviors.autoComplete = {
        attach: function autoComplete(context, settings) {
            var facetId = settings.facets.id,
                domId   = '.js-facets-autocomplete',
                options = {
                    data: settings.facets.autocomplete_widget[facetId]['facet-data'],
                    getValue: function(ele) { return ele.name; },
                    list: {
                        match: { enabled: true },
                        onClickEvent: function() {
                            var itemData = $(domId).getSelectedItemData();
                            console.log(itemData);
                        }
                    }
                };

            console.log(context, settings);

            $('.js-facets-autocomplete').easyAutocomplete(options);


        }
    };

})(jQuery, _, Drupal);