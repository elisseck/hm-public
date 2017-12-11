<?php

namespace Drupal\page_banner\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Provides a 'Page Banner' Block.
 *
 * @Block(
 *   id = "page_banner_block",
 *   admin_label = @Translation("Page Banner Block"),
 *   category = @Translation("Blocks"),
 * )
 */
class PageBanner extends BlockBase {

// BLOCK FORM
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    //Page Banner Defaults
    $form['background_color'] = array (
      '#type' => 'select',
      '#title' => $this->t('Background Color'),
      '#description' => $this->t('Background color of banner.  Background image will override the display of a background color.'),
      '#options' => array(
        1 => '#941A1D', 
        2 => '#682052', 
        3 => '#2e2d6f'),
      '#default_value' => isset($config['#941A1D']) ? $config['#941A1D'] : '',
    );      
    //Featured Person (Name, Portrait, Occupation)
    $form['feature_name'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Feature Name'),
      '#description' => $this->t('What is the name of the person to be featured in this section?'),
      '#default_value' => isset($config['feature_name']) ? $config['feature_name'] : '',
    );    
    $form['feature_image'] = array (
        '#type' => 'managed_file',
        '#title' => $this->t('Feature image'),
        '#description' => $this->t('Add a portrait of the featured person.'),
        '#default_value' => isset($config['feature_image']) ? $config['feature_image'] : '',
        '#upload_location' => 'public://pictures/page_banner/',
        '#upload_validators' => array(
            'file_validate_is_image' => array(),
            'file_validate_extensions' => array('gif png jpg jpeg'),
            'file_validate_size' => array(6 * 1024 * 1024),
        ),
    );
    $form['feature_occupation'] = array (
        '#type' => 'textarea',
        '#title' => $this->t('Features Occupation'),
        '#description' => $this->t('What is/was the occupation/s of the featured person?  Use a comma to separate occupations. '),
        '#default_value' => isset($config['feature_occupation']) ? $config['feature_occupation'] : '',
    );
    //Sponsor (Name/Company and Image/Logo)
    $form['sponsor_name'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Sponsor Name'),
      '#description' => $this->t('What is the name of the sponsor representing this section?'),
      '#default_value' => isset($config['sponsor_name']) ? $config['sponsor_name'] : '',
    );    
    $form['sponsor_image'] = array (
        '#type' => 'managed_file',
        '#title' => $this->t('Sponsor Image'),
        '#description' => $this->t('Add an image or logo for the sponsor'),
        '#default_value' => isset($config['sponsor_image']) ? $config['sponsor_image'] : '',
        '#upload_location' => 'public://pictures/page_banner/',
        '#upload_validators' => array(
            'file_validate_is_image' => array(),
            'file_validate_extensions' => array('gif png jpg jpeg'),
            'file_validate_size' => array(6 * 1024 * 1024),
        ),
    );    
    return $form;
  }

  protected function getImagePath($fid) {
    if (!$fid) return false;

    $file = \Drupal\file\Entity\File::load($fid);
    $file->getFilename();
    return file_url_transform_relative(file_create_url($file->getFileUri()));
  }

  /**
   * {@inheritdoc}
   */

// BLOCK SUBMIT
  public function blockSubmit($form, FormStateInterface $form_state) {
    \drupal_set_message('feat: ' . $form_state->getValue(['feature_image', 0]));
    \drupal_set_message('spons: ' . $form_state->getValue(['sponsor_image', 0]));
    $values = $form_state->getValues();
    if (!empty($values['feature_image'])) {
      $this->setConfigurationValue('feature_image', $values['feature_image']);
    }
    if (!empty($values['sponsor_image'])) {
      $this->setConfigurationValue('sponsor_image', $values['sponsor_image']);
    }   
    $this->setConfigurationValue('background_color', $values['background_color']);   
    $this->setConfigurationValue('feature_name', $form_state->getValue('feature_name'));   
    $this->setConfigurationValue('feature_occupation', $form_state->getValue('feature_occupation'));
    $this->setConfigurationValue('sponsor_name', $form_state->getValue('sponsor_name')); 
  }

// BLOCK BUILD
  public function build() {
    $config = $this->getConfiguration();
    drupal_set_message(print_r($config, true));
    if (!empty($config['background_color'])) {
      $background_color = $config['background_color'];
    }
    else {
      $background_color = $this->t('#941A1D');
    }
    if (!empty($config['feature_name'])) {
      $feature_name = $config['feature_name'];
    }
    else {
      $feature_name = $this->t('feature_name');
    }
    if (!empty($config['feature_image'])) {
      $feature_image = $this->getImagePath($config['feature_image'][0]);
    }

    if (!empty($config['feature_occupation'])) {
      $feature_occupation = $config['feature_occupation'];
    }
    else {
      $feature_occupation = $this->t('feature_occupation');
    }
    if (!empty($config['sponsor_name'])) {
      $sponsor_name = $config['sponsor_name'];
    }
    else {
      $sponsor_name = $this->t('sponsor_name');
    }
    if (!empty($config['sponsor_image'])) {
      $sponsor_image = $this->getImagePath($config['sponsor_image'][0]);
    }
    else {
      $sponsor_image = $this->t('sponsor_image');
    }
    return [
      '#theme' => 'mypluginBanner',
      'variables' => [
        'background_color' => $background_color, 
        'feature_name' => $feature_name,       
        'feature_occupation' => $feature_occupation, 
        'feature_image' => $feature_image, 
        'sponsor_name' => $sponsor_name, 
        'sponsor_image' => $sponsor_image, 
      ]
    ];
  }

} //The End