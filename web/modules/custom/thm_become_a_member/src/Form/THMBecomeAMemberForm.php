<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 1/5/18
 * Time: 11:20 AM
 */

namespace Drupal\thm_become_a_member\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\commerce_cart\CartSession;


class THMBecomeAMemberForm extends FormBase {

  public function getStore($storeId = 1) {
    return \Drupal::entityManager()
      ->getStorage('commerce_store')
      ->load($storeId);
  }

  public function getProductVariation($variation) {
    return \Drupal::entityManager()
      ->getStorage('commerce_product_variation')
      ->load($variation);
  }

  public function makeCart() {

    $orderType    = 'default';
    $varId        = 1;

    $entityMgr    = \Drupal::entityManager();
    $cartMgr      = \Drupal::service('commerce_cart.cart_manager');
    $cartProvider = \Drupal::service('commerce_cart.cart_provider');

    $store = $this->getStore();
    $productVar = $this->getProductVariation($varId);

    $cart = $cartProvider->getCart($orderType, $store);

    if (!$cart) {
      $cart = $cartProvider->createCart($orderType, $store);
    }

    $orderItem = $entityMgr->getStorage('commerce_order_item')
      ->create([
        'type' => 'default',
        'purchased_entity' => (string) $varId,
        'quantity' => 1,
        'unit_price' => $productVar->getPrice()
      ]);

    $orderItem->save();
    $cartMgr->addOrderItem($cart, $orderItem);


    // need to redirect to /checkout/{cart_id}/login, but w/o a session context,
    // (I think) you can't directly jump into checkout flow
    return $cart;
  }

  public function goto($path) {
    $res = new RedirectResponse($path);
    $res->send();
  }

  public function prepOrder() {
    $session = \Drupal::service('session');

    $cartSession = new CartSession($session);
    $cart        = $this->makeCart();
    $cartId      = $cart->id();
    $cartSession->addCartId($cartId);

    $this->goto("/checkout/$cartId/login");
  }

  public function getFormId() {
    return 'create_thmda_order';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions']['#type'] = 'actions';

    $form['simple_form'] = [
      '#type' => 'submit',
      '#value' => t('Become a DigitalMaker'),
      '#submit' => [ '::prepOrder' ]
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}