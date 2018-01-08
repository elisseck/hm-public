<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 1/4/18
 * Time: 3:23 PM
 */

namespace Drupal\thm_checkout_registration\Plugin\Commerce\CheckoutPane;

use Drupal\user\UserInterface;
use Drupal\commerce_checkout\Plugin\Commerce\CheckoutFlow\CheckoutFlowInterface;
use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, CheckoutFlowInterface $checkout_flow = NULL) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $checkout_flow,
      $container->get('entity_type.manager'),
      $container->get('commerce.credentials_check_flood'),
      $container->get('current_user'),
      $container->get('user.auth'),
      $container->get('request_stack')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['user_profile_form'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Enter Contact Information'),
      '#attributes' => [
        'class' => [
          'form-wrapper__login-option',
          'form-wrapper__guest-checkout',
        ],
      ],
    ];

    $pane_form['user_profile_form']['user_account'] = [
      '#type' => 'webform',
      '#webform' => 'user_registration'
    ];

    $pane_form['register'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('New Customer'),
      '#attributes' => [
        'class' => [
          'form-wrapper__login-option',
          'form-wrapper__guest-checkout',
        ],
      ],
    ];
    $pane_form['register']['mail'] = [
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#required' => FALSE,
    ];
    $pane_form['register']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
      '#description' => $this->t("Several special characters are allowed, including space, period (.), hyphen (-), apostrophe ('), underscore (_), and the @ sign."),
      '#required' => FALSE,
      '#attributes' => [
        'class' => ['username'],
        'autocorrect' => 'off',
        'autocapitalize' => 'off',
        'spellcheck' => 'false',
      ],
      '#default_value' => '',
    ];
    $pane_form['register']['password'] = [
      '#type' => 'password_confirm',
      '#size' => 60,
      '#description' => $this->t('Provide a password for the new account in both fields.'),
      '#required' => FALSE,
    ];
    $pane_form['register']['register'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create account and continue'),
      '#op' => 'register',
    ];

    return $pane_form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitPaneForm(array &$pane_form, FormStateInterface $form_state, array &$complete_form) {
    $triggering_element = $form_state->getTriggeringElement();
    switch ($triggering_element['#op']) {
      case 'continue':
        break;

      case 'login':
      case 'register':
        $storage = $this->entityTypeManager->getStorage('user');
        /** @var \Drupal\user\UserInterface $account */
        $account = $storage->load($form_state->get('logged_in_uid'));
        user_login_finalize($account);
        $this->order->setCustomer($account);
        $this->credentialsCheckFlood->clearAccount($this->clientIp, $account->getAccountName());
        break;
    }

    $form_state->setRedirect('commerce_checkout.form', [
      'commerce_order' => $this->order->id(),
      'step' => $this->checkoutFlow->getNextStepId($this->getStepId()),
    ]);
  }
}