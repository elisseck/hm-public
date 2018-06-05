
(function ($, Drupal) {
    'use strict';

    Drupal.thm = Drupal.thm || {};

    Drupal.thm.filtersApplied = false;

    Drupal.thm.filterResetCls = '.thm-adv-search-filter-mgmt';

    Drupal.thm.widgetCls = '.js-facets-autocomplete';

    Drupal.thm.taxonomyWidgets = [ 'birth_place_term' ];

    Drupal.thm.excludeWidgets = [ 'maker_category' ];

    Drupal.thm.handleFilterReset = function(settings) {
        $('#filter-reset').on('click', function(evt) {
            evt.preventDefault();
            window.location.replace(settings.path.baseUrl + settings.path.currentPath);
        });
    };

    Drupal.behaviors.autoComplete = {
        attach: function autoComplete(context, settings) {
            $(Drupal.thm.widgetCls).once().each(_bindAutocomplete);

            if (!Drupal.thm.filtersApplied) {
                Drupal.thm.handleFilterReset(settings);
                _applyFiltersInUrl(settings);
            }
        }
    };

    function _bindAutocomplete() {
        var ele      = $(this),
            widgetId = _getWidgetId(ele),
            options  = {
                getValue: function(e) { return e.name; },
                url: '/fetch-facet-data/' + widgetId,
                list: {
                    match: { enabled: true },
                    onClickEvent: function() { _addFilter($(ele).getSelectedItemData()); }
                }
            };
        $(ele).easyAutocomplete(options);
    }

    function _applyFiltersInUrl(settings) {
        Drupal.thm.filtersApplied = true;

        if (!settings.path.hasOwnProperty('currentQuery')) {
            return false;
        }

        var filters = settings.path.currentQuery.f;

        Object.keys(filters).forEach(function(filter) {
            var args = filters[filter].split(':');

            if (Drupal.thm.excludeWidgets.includes(args[0])) {
                return;
            } else if (Drupal.thm.taxonomyWidgets.includes(args[0])) {
                _lookUpTerm(filters[filter]);
            } else {
                _createFilterControl({ name: args[1], field: args[0] });
            }
        });
    }

    function _createFilterControl(cfg) {
        var ele = [
                '<div data-facet-field-name="', cfg.field, '"',
                'data-facet-field-value="', cfg.name, '"',
                'data-facet-field-id="', cfg.id || 0, '">',
                cfg.name, '</div>'
            ].join(''),
            $filterCtrl = $(ele);

        $($filterCtrl).on('click', _removeFilter);
        $(Drupal.thm.filterResetCls).append($filterCtrl);
    }
    
    function _removeFilter(evt) {
        var $ele   = $(this),
            $data  = _extractDataFromFilterControl($ele),
            url    = window.location.href,
            entry  = '';

        if ($data.id) {
            entry = encodeURIComponent($data.field + ':' + $data.id);
        } else {
            entry = encodeURIComponent($data.field + ':' + $data.value);
        }

        var url = url.replace(new RegExp('^.+(f\[[0-9]+\]=' + entry + ')$'), _refreshUrl);
        console.log('removing ', entry);
        console.log('new url ', url)
    }

    function _extractDataFromFilterControl($ele) {
        return {
            id: $ele.data('facetFieldId'),
            value: $ele.data('facetFieldValue'),
            field: $ele.data('facetFieldName')
        }
    }

    function _refreshUrl(match, entry, offset, string) {
        var beginIdx = string.indexOf(entry),
            endIdx   = match.length;
        console.log(arguments);
    }

    function _lookUpTerm(arg) {
        var args = arg.split(':');

        fetch('/fetch-facet-data/' + args[0]).then(function(response) {
            return response.json();
        }).then(function(data) {
            var filterName = data.find(function(item) { return item.value.endsWith(args[1]); }).name;
            _createFilterControl({ name: filterName, field: args[0], id: args[1] });
        });
    }

    function _addFilter(data) {
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
        var module = 'thm_adv_search_';
        var id = [].find.call(ele[0].classList, function(item) {
            return item.startsWith(module);
        });

        return id.substring(module.length);
    }

})(jQuery, Drupal);