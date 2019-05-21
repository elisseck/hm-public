<?php
/**
 * Created by PhpStorm.
 * User: tone
 * Date: 8/6/18
 * Time: 3:47 PM
 */

namespace Drupal\thm_adv_search_facet_container\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FacetsContainer' block.
 *
 * @Block(
 *  id = "block_facets_container",
 *  admin_label = @Translation("Facet Container Block"),
 * )
 */
class FacetsContainer extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      'facets_container' => [
        '#theme' => 'thm_adv_search_facet_container'
      ]
    ];
  }
}
