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
  function thm_related_makers_get_current_node() {
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof NodeInterface) {
      return $node;
    } else {
      return false;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'angular',
      '#attached' => array(
        'library' => array(
            'thm_angular/inline.bundle.js',
            'thm_angular/polyfills.bundle.js',
            'thm_angular/styles.bundle.js',
            'thm_angular/vendor.bundle.js',
            'thm_angular/main.bundle.js',
        ),
      ),
    ];
  }

}