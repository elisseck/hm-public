(function ($, Drupal) {
    'use strict';

    Drupal.thm = Drupal.thm || {};

    Drupal.thm.filtersApplied = false;

    Drupal.thm.filterResetCls = '.thm-adv-search-filter-mgmt';

    Drupal.thm.widgetCls = '.js-facets-autocomplete';

    Drupal.thm.taxonomyWidgets = [
        'birthplace_', 'occupation_', 'organizations_'
    ];

    Drupal.thm.excludeWidgets = [ 'maker_category' ];

    if (!Array.prototype.find) {
      Object.defineProperty(Array.prototype, 'find', {
        value: function(predicate) {
          // 1. Let O be ? ToObject(this value).
          if (this == null) {
            throw new TypeError('"this" is null or not defined');
          }

          var o = Object(this);

          // 2. Let len be ? ToLength(? Get(O, "length")).
          var len = o.length >>> 0;

          // 3. If IsCallable(predicate) is false, throw a TypeError exception.
          if (typeof predicate !== 'function') {
            throw new TypeError('predicate must be a function');
          }

          // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
          var thisArg = arguments[1];

          // 5. Let k be 0.
          var k = 0;

          // 6. Repeat, while k < len
          while (k < len) {
            // a. Let Pk be ! ToString(k).
            // b. Let kValue be ? Get(O, Pk).
            // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
            // d. If testResult is true, return kValue.
            var kValue = o[k];
            if (predicate.call(thisArg, kValue, k, o)) {
              return kValue;
            }
            // e. Increase k by 1.
            k++;
          }

          // 7. Return undefined.
          return undefined;
        }
      });
    }

    if (!String.prototype.startsWith) {
      String.prototype.startsWith = function(searchString, position){
        position = position || 0;
        return this.substr(position, searchString.length) === searchString;
      };
    }

    Drupal.behaviors.autoComplete = {
        attach: function autoComplete(context, settings) {
            $(Drupal.thm.widgetCls).once().each(_bindAutocomplete);

            if (!Drupal.thm.filtersApplied) {
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
                adjustWidth: false,
                list: {
                    match: { enabled: true },
                    onChooseEvent: function() { _addFilter($(ele).getSelectedItemData()); }
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
                //console.log('perform lookup for: ', filters[filter]);
                _lookUpTerm(filters[filter]);
            } else {
                //console.log('create filter for: ', args[1], args[0]);
                _createFilterControl({ name: args[1], field: args[0] });
            }
        });
    }

    function _createFilterControl(cfg) {
        var ele = [
                '<div data-facet-field-name="', cfg.field, '"',
                'data-facet-field-value="', cfg.name, '"',
                'data-facet-field-id="', cfg.id || 0, '">',
                cfg.name, ' &times;</div>'
            ].join(''),
            $filterCtrl = $(ele);

        $($filterCtrl).on('click', _removeFilter);
        $(Drupal.thm.filterResetCls).append($filterCtrl);
    }
    
    function _removeFilter() {
        var $ele  = $(this),
            $data = _extractDataFromFilterControl($ele),
            url   = decodeURIComponent(window.location.href),
            entry, newUrl = null;

        if ($data.id) {
            entry = $data.field + ':' + $data.id;
        } else {
            entry = $data.field + ':' + $data.value;
        }

        newUrl = url.replace(new RegExp('^(.+?)(&?f\\[[0-9]+\\]=' + entry + ')(.*?)$', 'g'), _refreshUrl);
        //console.log(url, newUrl);
        window.location.replace(encodeURI(newUrl));
    }

    function _extractDataFromFilterControl($ele) {
        return {
            id: $ele.data('facetFieldId'),
            value: $ele.data('facetFieldValue'),
            field: $ele.data('facetFieldName')
        };
    }

    function _refreshUrl(match, prefix, entry, suffix, offset, string) {
        //console.log('in refresher. . .', arguments);
        var output = prefix + suffix;
        return (output[output.length - 1] === '?') ? output.substring(0, output.length - 1) : output;
    }

    function _lookUpTerm(arg) {
        var args = arg.split(':');

        fetch('/fetch-facet-data/' + args[0]).then(function(response) {
            return response.json();
        }).then(function(data) {
            var filterName = data.find(function(item) { return item.value.endsWith(args[1]); }).name;
            _createFilterControl({ name: filterName, field: args[0], id: args[1] });
        }).catch(function(err) {
            console.error('An error occurred retrieving data for the %s facet', args[0]);
            console.error(err);
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
