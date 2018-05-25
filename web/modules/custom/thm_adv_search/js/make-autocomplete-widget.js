
(function ($, Drupal) {
    'use strict';

    Drupal.thm = Drupal.thm || {};
    Drupal.behaviors.autoComplete = {
        attach: function autoComplete(context, settings) {
            var domCls = '.js-facets-autocomplete';
            [].forEach.call(document.querySelectorAll(domCls), _bind(settings));
        }
    };

    function _bind(settings) {
        return function(ele) {
            var widgetId = _getWidgetId(ele),
                options = {
                    getValue: function(e) { return e.name; },
                    data: settings.facets.autocomplete_widget[widgetId]['facet-data'],
                    list: {
                        match: { enabled: true },
                        onClickEvent: function() { _applyFilter($(ele).getSelectedItemData()); }
                    }
                };
            $(ele).easyAutocomplete(options);
        }
    }

    function _applyFilter(data) {
        _parseUrl(window.location.href, data);
    }

    function _parseUrl(url, data) {
        var parts = url.split('?');

        if (parts.length < 2) {
            window.location.replace(url + '?' + 'f[0]=' + data.value);
        } else {
            var facets      = decodeURIComponent(parts[parts.length - 1]).split('&'),
                facetLength = facets.length,
                output      = 'f[' + (facetLength + 1) + ']=' + data.value;

            window.location.replace(url + '&' + output);
        }
    }

    function _getWidgetId(ele) {
        var module  = 'thm-adv-search-';

        return [].find.call(ele.classList, function(item) {
            return item.startsWith(module);
        });
    }

})(jQuery, Drupal);