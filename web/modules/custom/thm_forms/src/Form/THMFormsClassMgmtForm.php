<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 8/16/18
 * Time: 12:41 PM
 */

namespace Drupal\thm_forms\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class THMFormsClassMgmtForm extends ConfigFormBase {
  protected function getEditableConfigNames() {
    return [ 'thm_forms.settings' ];
  }

  public function getFormId() {
    return 'thm_forms_config_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $formId = 'forms_class_mgr';
    $config = $this->config('thm_forms.settings');

    $form[$formId] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Drupal Forms - CSS Class Management')
    ];

    $form[$formId]['debug_toggle'] = [
      '#type' => 'checkbox',
      '#default_value' => $config->get('thm_forms.debug_toggle'),
      '#title' => $this->t('Check here to display the form IDs present on each page.')
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $formState) {
    $values = $formState->getValues();

    $this->configFactory->getEditable('thm_forms.settings')
      ->set('thm_forms.debug_toggle', $values['debug_toggle'])
      ->save();

    parent::submitForm($form, $formState);
  }
}