<?php
/**
 * Created by PhpStorm.
 * User: tone
 * Date: 3/20/19
 * Time: 1:31 PM
 */

namespace Drupal\thm_jwt\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface as FSI;


class URLConfigForm extends ConfigFormBase {

  public function getFormId() {
    return 'digital_archive_url_config_form';
  }

  public function buildForm(array $form, FSI $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('digital_archive_urls.settings');

    $form['primary_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Digital Archive URL'),
      '#default_value' => $config->get('digital_archive_urls.main'),
      '#required' => true
    ];

    $form['science_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Science Makers DA URL'),
      '#default_value' => $config->get('digital_archive_urls.science'),
      '#required' => true
    ];

    return $form;
  }

  public function submitForm(array &$form, FSI $formState) {
    $config = $this->config('digital_archive_urls.settings');
    $config->set('digital_archive_urls.main', $formState->getValue('primary_url'));
    $config->set('digital_archive_urls.science', $formState->getValue('science_url'));
    $config->save();
    parent::submitForm($form, $formState);
  }

  public function getEditableConfigNames() {
    return [ 'digital_archive_urls.settings' ];
  }
}
