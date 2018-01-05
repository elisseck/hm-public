<?php

namespace Drupal\thm_become_a_member\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\commerce_cart\CartSession;

/**
 * Class THMBecomeAMemberController.
 */
class THMBecomeAMemberController extends ControllerBase {

  public function getStore() {
    return \Drupal::entityManager()
      ->getStorage('commerce_store')
      ->load(1);
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
    // you can't directly jump into checkout flow
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
    $cartSession->addCartId($cart->id());
  }

  public function content() {

    //drupal_set_message(($session->isStarted()) ? 'session started' : 'no session found');
    return [
      'form' => $this->formBuilder()->getForm('\Drupal\thm_become_a_member\Form\THMBecomeAMemberForm'),
    ];
  }
}
