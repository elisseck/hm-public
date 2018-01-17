<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 1/12/18
 * Time: 12:46 PM
 */

namespace Drupal\thm_checkout_registration\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserInterface;

/**
 * Provides the completion message pane.
 *
 * @CommerceCheckoutPane(
 *   id = "thmda_signup_completion",
 *   label = @Translation("THM Completion Step"),
 *   default_step = "disabled",
 * )
 */
class THMDAComplete extends CheckoutPaneBase {

  /**
   * @var UserInterface
   */
  protected $user;

  public function assignRole() {
    $this->user->addRole('thm_paid_member');
    $this->user->save();
  }

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['#theme'] = 'thm_checkout_registration_complete';

    $this->user = $this->entityTypeManager
      ->getStorage('user')
      ->load($this->order->getCustomerId());

    $this->assignRole();

    return $pane_form;
  }

}