<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 5/15/18
 * Time: 4:22 PM
 */

namespace Drupal\thm_adv_search\Plugin\facets\widget;

use Drupal\facets\FacetInterface;
use Drupal\facets\Widget\WidgetPluginBase;


/**
 * Class AutoComplete
 *
 * @package Drupal\thm_adv_search\Plugin\facets\widget
 *
 * @FacetsWidget(
 *   id = "autocomplete_widget",
 *   label = @Translation("AutoCompleteWidget"),
 *   description = @Translation("An autocomplete widget.")
 * )
 */
class AutoCompleteWidget extends WidgetPluginBase {

  protected function prefixify(string $s) {
    return 'thm_adv_search_' . $s;
  }

  protected function normalizeId(string $facetId) {
    return rtrim(ucwords(str_replace('_', ' ', $facetId)));
  }

  public function build(FacetInterface $facet) {
    $clsId = $this->prefixify($facet->id());

    $build['#type'] = 'textfield';
    $build['#attached']['library'][] = 'thm_adv_search/auto-complete-widget';
    $build['#attributes']['class'] = [/*'form-autocomplete',*/ 'js-facets-autocomplete', $clsId];
    $build['#attributes']['placeholder'] = 'Enter ' . $this->normalizeId($facet->id());
    return $build;
  }
}
