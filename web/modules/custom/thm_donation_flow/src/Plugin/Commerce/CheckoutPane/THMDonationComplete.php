<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 4/11/18
 * Time: 3:07 PM
 */

namespace Drupal\thm_donation_flow\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the completion message pane.
 *
 * @CommerceCheckoutPane(
 *   id = "thm_donation_completion",
 *   label = @Translation("THM Donation Complete"),
 *   default_step = "disabled",
 * )
 */
class THMDonationComplete extends CheckoutPaneBase {
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['#theme'] = 'thm_donation_complete';

    return $pane_form;
  }
}