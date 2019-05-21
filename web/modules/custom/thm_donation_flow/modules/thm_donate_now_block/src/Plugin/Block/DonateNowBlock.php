<?php
/**
 * Created by PhpStorm.
 * User: tone
 * Date: 10/22/18
 * Time: 11:00 PM
 */

namespace Drupal\thm_donate_now_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Renderer;


/**
 * Class DonateNowBlock
 *
 * @package Drupal\thm_donate_now_block\Plugin\Block
 *
 * @Block(
 *   id = "donate_now_block",
 *   admin_label = @Translation("Donate Now!"),
 *   category = @Translation("Donations")
 * )
 */
class DonateNowBlock extends BlockBase{

  public function build() {
    $donationForm = '\Drupal\thm_donation_flow\Form\THMBlockDonationForm';
    return [
      '#theme' => 'thm_donation_block_cta',
      '#donation_form' => \Drupal::formBuilder()->getForm($donationForm)
    ];
  }
}