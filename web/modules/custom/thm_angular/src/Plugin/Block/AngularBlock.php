<?php

namespace Drupal\thm_angular\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'angular',
    ];
  }

}