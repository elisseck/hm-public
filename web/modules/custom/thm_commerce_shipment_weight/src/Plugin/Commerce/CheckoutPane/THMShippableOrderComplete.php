<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 4/11/18
 * Time: 3:53 PM
 */
namespace Drupal\thm_commerce_shipment_weight\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the completion message pane.
 *
 * @CommerceCheckoutPane(
 *   id = "thm_shippable_order_completion",
 *   label = @Translation("THM Shippable Order Complete"),
 *   default_step = "disabled",
 * )
 */
class THMShippableOrderComplete extends CheckoutPaneBase {
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['#theme'] = 'thm_shippable_order_complete';

    return $pane_form;
  }
}