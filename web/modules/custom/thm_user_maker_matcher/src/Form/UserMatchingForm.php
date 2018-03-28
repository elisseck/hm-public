<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 3/27/18
 * Time: 1:31 PM
 */

namespace Drupal\thm_user_maker_matcher\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class UserMatchingForm extends FormBase {

  /**
   * @var AccountInterface $account
   */
  protected $account;

  public function __construct(AccountInterface $account) {
    $this->account = $account;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('current_user'));
  }

  public function getFormId() {
    return 'maker_matcher';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['makermatcher_form'] = [
      '#type' => 'webform',
      '#webform' => 'makermatcher_form'
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    return false;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state); // TODO: Change the autogenerated stub
  }
}