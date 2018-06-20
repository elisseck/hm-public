<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 6/12/18
 * Time: 3:58 PM
 */

namespace Drupal\thm_adv_search\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class AdminSearchExclude extends ConfigFormBase {

  public function getEditableConfigNames() {
    return [ 'thm_adv_search.settings' ];
  }

  public function getFormId() {
    return 'thm_adv_search_bundle_exclude';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('thm_adv_search.settings');
    $bundles = $config->get('bundles') ? $config->get('bundles') : [];

    $types = \Drupal::entityTypeManager()->getStorage('node_type')->loadMultiple();

    $options = [];

    foreach ($types as $type) {
      $options[$type->id()] = $type->label();
    }

    $form['bundles'] = [
      '#type' => 'checkboxes',
      '#options' => $options,
      '#title' => $this->t('Content types to exclude from this search'),
      '#default_value' => $bundles
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('thm_adv_search.settings')
      ->set('bundles', $form_state->getValue('bundles'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}