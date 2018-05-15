
(function ($, maquette, Drupal) {
    'use strict';

    var h = maquette.h,
        projector = maquette.createProjector();

    Drupal.thm = Drupal.thm || {};
    Drupal.behaviors.dropdownCollection = {
        attach: function dropdownCollection(context, settings) {
            Drupal.thm.manageDropdownCollection(context, settings);
            //Drupal.thm.makeDropdown(context, settings);
        }
    };

    function _getAttributes(ele) {
        var output = {},
            attrs  = ele.attributes;

        for (var i = attrs - 1; i >= 0; i--) {
            output[attrs[i].name] = output[i].value;
        }
        return output;
    }

    Drupal.thm.buildDropDown = function() {
        var dropdownSelector = '.js-facets-dropdown-links',
            linkSelector = '.facet-item a',
            parent = null,
            $lists = document.querySelectorAll(dropdownSelector);

        return {
            elements: Array.prototype.map.call($lists, function(dropDownEle) {
                var $links  = dropDownEle.querySelectorAll(linkSelector),
                    $attrs  = _getAttributes(dropDownEle),
                    facetId = dropDownEle.dataset.drupalFacetId;

                $attrs.class += ' facets-dropdown';

                if (!parent) parent = dropDownEle.parentNode;

                return {
                    render: function() {
                        return h('select', $attrs, [
                            Drupal.thm.buildLinks($links).map(function($link) {
                                return $link.render();
                            })
                        ]);
                    }
                };
            }),
            parentElement: parent

        };
    };

    Drupal.thm.buildLinks = function($links) {
        return Array.prototype.map.call($links, function($link) {

            var facetItemId = $link.dataset.drupalFacetItemId;

            return {
                render: function() {
                    return h('option#' + facetItemId, {
                        key: facetItemId, value: $link.href,
                    }, [ $link.innerHTML ]);
                }
            };
        });
    };

    Drupal.thm.manageDropdownCollection = function manageDropdownCollection(context, settings) {
        var data = Drupal.thm.buildDropDown();

        function _render() {
            /*return h('div', {class: 'foo'}, [
                h('p', {class: 'bar'}, ['testing. . .'])
            ]);*/
            /*return data.elements.map(function(ele) {
                return ele.render();
            });*/
        }

        if (data.parentElement) projector.append(data.parentElement, _render);
        /*$('.js-facets-dropdown-links').once('facets-dropdown-transform').each(function() {

        });*/
    };

    /**
     * Turns all facet links into a dropdown with options for every link.
     *
     * @param {object} context
     *   Context.
     * @param {object} settings
     *   Settings.
     */
    Drupal.thm.makeDropdown = function (context, settings) {
        // Find all dropdown facet links and turn them into an option.
        $('.js-facets-dropdown-links').once('facets-dropdown-transform').each(function () {
            var $ul = $(this);
            var $links = $ul.find('.facet-item a');
            var $dropdown = $('<select />');
            // Preserve all attributes of the list.
            $ul.each(function() {
                $.each(this.attributes,function(idx, elem) {
                    console.log('attribute name: ', elem.name);
                    console.log('attribute value: ', elem.value);
                    $dropdown.attr(elem.name, elem.value);
                });
            });
            // Remove the class which we are using for .once().
            $dropdown.removeClass('js-facets-dropdown-links');

            $dropdown.addClass('facets-dropdown');

            var id = $(this).data('drupal-facet-id');
            var default_option_label = settings.facets.dropdown_widget[id]['facet-default-option-label'];
            // Add empty text option first.
            var $default_option = $('<option />')
                .attr('value', '')
                .text(default_option_label);
            $dropdown.append($default_option);

            var has_active = false;
            $links.each(function () {
                var $link = $(this);
                var active = $link.hasClass('is-active');
                var $option = $('<option />')
                    .attr('value', $link.attr('href'))
                    .data($link.data());
                if (active) {
                    has_active = true;
                    // Set empty text value to this link to unselect facet.
                    $default_option.attr('value', $link.attr('href'));

                    $option.attr('selected', 'selected');
                    $link.find('.js-facet-deactivate').remove();
                }
                $option.html($link.text());
                $dropdown.append($option);
            });

            // Go to the selected option when it's clicked.
            $dropdown.on('change.facets', function () {
                window.location.href = $(this).val();
            });

            // Append empty text option.
            if (!has_active) {
                $default_option.attr('selected', 'selected');
            }

            // Replace links with dropdown.
            $ul.after($dropdown).remove();
            Drupal.attachBehaviors($dropdown.parent()[0], Drupal.settings);
        });
    };

})(jQuery, maquette, Drupal);