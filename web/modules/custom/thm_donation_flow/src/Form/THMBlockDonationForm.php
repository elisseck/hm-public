<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 10/10/18
 * Time: 2:26 PM
 */

namespace Drupal\thm_donation_flow\Form;

use Drupal\Core\Form\FormStateInterface;


class THMBlockDonationForm extends THMDonationForm {
  public function getFormId() {
    return 'make_a_donation_block';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['block_donation_form'] = [
      '#type' => 'submit',
      '#value' => t('Donate Now')
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    return parent::submitForm($form, $form_state);
  }
}