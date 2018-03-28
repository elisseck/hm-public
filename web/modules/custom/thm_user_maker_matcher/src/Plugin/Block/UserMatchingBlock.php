<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 3/28/18
 * Time: 12:33 PM
 */

namespace Drupal\thm_user_maker_matcher\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\thm_user_maker_matcher\Form\UserMatchingForm;


/**
 * Provides a custom block for the User Matching Engine.
 *
 * @package Drupal\thm_user_maker_matcher\Plugin\Block
 *
 * @Block(
 *   id = "user_matching_block",
 *   admin_label = @Translation("MakerMatcher Block"),
 *   category = @Translation("MakerMatcher Block Module"),
 * )
 */
class UserMatchingBlock extends BlockBase{

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm(UserMatchingForm::class);
  }
}