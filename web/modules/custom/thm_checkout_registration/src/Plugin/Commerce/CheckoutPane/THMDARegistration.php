<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 1/4/18
 * Time: 3:23 PM
 */

namespace Drupal\thm_checkout_registration\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Custom Commerce Checkout (login/registration) Pane
 *
 * @CommerceCheckoutPane(
 *   id = "thmda_access_registration",
 *   label = @Translation("THM Digital Access Registration Step"),
 *   default_step = "login",
 * )
 */
class THMDARegistration extends CheckoutPaneBase {

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['thmda_registration_form'] = [
      '#type' => 'webform',
      '#webform' => 'user_registration'
    ];

    return $pane_form;
  }
}