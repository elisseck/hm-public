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
 *   admin_label = @Translation("Page Banner"),
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
        '#941A1D' => $this->t('#941A1D'), 
        '#682052' => $this->t('#682052'), 
        '#2e2d6f' => $this->t('#2e2d6f') ),
      '#default_value' => '#941A1D',
    );   
    $form['background_image'] = array (
      '#type' => 'managed_file',
      '#title' => $this->t('Background image'),
      '#description' => $this->t('Add a background image for the banner. Attached image will override background color.'),
      '#default_value' => isset($config['background_image']) ? $config['background_image'] : '',
      '#upload_location' => 'public://pictures/page_banner/',
      '#upload_validators' => array(
          'file_validate_is_image' => array(),
          'file_validate_extensions' => array('gif png jpg jpeg'),
          'file_validate_size' => array(6 * 1024 * 1024),
      ),
    );       
    //Highlighted Banner Section (Name/Sponsor, Portrait/Logo, Occupation)
    $form['highlight_section'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Sponsor or Feature Maker?'),
      '#description' => $this->t('Is the banner highlighting a Feature Maker or a Sponsor?'),
      '#default_value' => isset($config['highlight_section']) ? $config['highlight_section'] : '',
    );  
    $form['highlight_section_name'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Highlight Section Name'),
      '#description' => $this->t('What is the name of the person to be highlighted in this section?  Or the name of the sponsor to be highlighted in this section?'),
      '#default_value' => isset($config['highlight_section_name']) ? $config['highlight_section_name'] : '',
    );    
    $form['highlight_section_image'] = array (
        '#type' => 'managed_file',
        '#title' => $this->t('Highlight Section Image'),
        '#description' => $this->t('Add a portrait of the highlighted person or a logo for a sponsor.'),
        '#default_value' => isset($config['highlight_section_image']) ? $config['highlight_section_image'] : '',
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
    return $form;
  }

  protected function getImagePath($fid) {
    if (!$fid || is_null($fid)) return false;

    $file = \Drupal\file\Entity\File::load($fid);
    return file_url_transform_relative(file_create_url($file->getFileUri()));
  }

  /**
   * {@inheritdoc}
   */

// BLOCK SUBMIT
  public function blockSubmit($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if (!empty($values['highlight_section_image'])) {
      $this->setConfigurationValue('highlight_section_image', $values['highlight_section_image']);
    }
    if (!empty($values['background_image'])) {
      $this->setConfigurationValue('background_image', $values['background_image']);
    }       
    $this->setConfigurationValue('background_color', $values['background_color']);   
    $this->setConfigurationValue('highlight_section', $form_state->getValue('highlight_section')); 
    $this->setConfigurationValue('highlight_section_name', $form_state->getValue('highlight_section_name'));   
    $this->setConfigurationValue('feature_occupation', $form_state->getValue('feature_occupation'));
  }

// BLOCK BUILD
  public function build() {
    $config = $this->getConfiguration();
    drupal_set_message(print_r($config, true));
    if (!empty($config['background_color'])) {
      $background_color = $config['background_color'];
    }
    if (!empty($config['background_image'])) {
      $background_image = $this->getImagePath(@$config['background_image'][0]);
    }       
    if (!empty($config['highlight_section'])) {
      $highlight_section = $config['highlight_section'];
    }
    if (!empty($config['highlight_section_name'])) {
      $highlight_section_name = $config['highlight_section_name'];
    }
    if (!empty($config['highlight_section_image'])) {
      $highlight_section_image = $this->getImagePath(@$config['highlight_section_image'][0]);
    }   
    if (!empty($config['feature_occupation'])) {
      $feature_occupation = $config['feature_occupation'];
    } 
    return [
      '#theme' => 'page_banner',
      '#banner_data' => [
        'background_color' => $background_color, 
        'background_image' => $background_image, 
        'highlight_section' => $highlight_section, 
        'highlight_section_name' => $highlight_section_name,       
        'feature_occupation' => $feature_occupation, 
        'highlight_section_image' => $highlight_section_image, 
        'sponsor_image' => $sponsor_image, 
      ]
    ];
  }

} //The End