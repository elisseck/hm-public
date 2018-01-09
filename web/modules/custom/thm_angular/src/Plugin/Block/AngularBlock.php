<?php

namespace Drupal\thm_angular\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\search_api\Entity\Index;
use Drupal\node\NodeInterface;
use Drupal\file\Entity\File;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "angular_block",
 *   admin_label = @Translation("Angular block"),
 *   category = @Translation("Angular World"),
 * )
 */


class AngularBlock extends BlockBase {
  /**
   * Retrieves the node in current display context (page|view|block).
   * Returns false if node isn't found.
   *
   * @return \Drupal\node\Entity\Node|bool
   */

  /**
   * {@inheritdoc}
   */
  public function build() {
    drupal_set_message(thm_angular_get_current_node()->getTitle());
    $build['thm_angular']['#theme'] = 'angular';
    $build['thm_angular']['#video'] = thm_angular_get_current_node();
  return $build;
  }

}