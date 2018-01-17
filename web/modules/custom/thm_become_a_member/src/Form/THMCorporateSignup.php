<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 1/12/18
 * Time: 3:39 PM
 */

namespace Drupal\thm_become_a_member\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class THMCorporateSignup extends FormBase {

  public function getFormId() {
    return 'signup_corporate';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['signup_form'] = [
      '#type' => 'submit',
      '#value' => t('Contact Us')
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message('industrymaker signup process goes here.');
  }

}
