<?php

namespace Drupal\hero_carousel\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\file\Entity\File;

/**
 * @Block(
 *     id = "carousel_block",
 *     admin_label = @Translation("Hero Carousel Block"),
 *     category = @Translation("Blocks")
 * )
 */
class Carousel extends BlockBase {

    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        $form['photo_1'] = array (
            '#type' => 'managed_file',
            '#title' => $this->t('Carousel Image #1'),
            '#description' => $this->t('What do you want the background image to be?'),
            '#default_value' => isset($config['photo_1']) ? $config['photo_1'] : '',
            '#upload_location' => 'public://pictures/home_carousel/',
            '#upload_validators' => array(
                'file_validate_is_image' => array(),
                'file_validate_extensions' => array('gif png jpg jpeg'),
                'file_validate_size' => array(6 * 1024 * 1024),
            ),
        );
        $form['quote_1'] = array (
            '#type' => 'textarea',
            '#title' => $this->t('Quote #1'),
            '#description' => $this->t('What quote do you want to go along with the image?'),
            '#default_value' => isset($config['quote_1']) ? $config['quote_1'] : '',
        );
        $form['citation_1'] = array (
            '#type' => 'textfield',
            '#title' => $this->t('Citation #1'),
            '#description' => $this->t('Who is the quote from?'),
            '#default_value' => isset($config['citation_1']) ? $config['citation_1'] : '',
        );
        return $form;
    }
      /**
       * {@inheritdoc}
       */

    //   $x = 'public://pictures/home_carousel/image_1.jpg';
    //   $pathToX = \Drupal::service('file_system')->realpath($x);
    //   $fid = \Drupal::database()->query("SELECT fid FROM {file_managed} WHERE filename = 'slide-1.jpg'")->fetchField();
      
    //   $file = \Drupal\file\Entity\File::load($fid);
    //   $file->getFilename();

    public function blockSubmit($form, FormStateInterface $form_state) {
        \drupal_set_message($form_state->getValue(['photo_1', 0]));
        $fid = $form_state->getValue(['photo_1', 0]);
        $file = \Drupal\file\Entity\File::load($fid);
        $file->getFilename();
        \drupal_set_message($file);
        $this->setConfigurationValue('photo_1', $form_state->getValue('photo_1'));
        $this->setConfigurationValue('quote_1', $form_state->getValue('quote_1'));
        $this->setConfigurationValue('citation_1', $form_state->getValue('citation_1'));
    }

    public function build() {
        $config = $this->getConfiguration();
        if (!empty($config['photo_1'])) {
          $photo_1 = $config['photo_1'];
        }
        else {
          $photo_1 = $this->t('photo_1');
        }
        if (!empty($config['quote_1'])) {
          $quote_1 = $config['quote_1'];
        }
        else {
          $quote_1 = $this->t('quote_1');
        }
        if (!empty($config['citation_1'])) {
          $citation_1 = $config['citation_1'];
        }
        else {
          $citation_1 = $this->t('citation_1');
        }
        return [
            '#theme' => 'myplugin',
            '#quote_1' => $quote_1, 
            '#photo_1' => $photo_1, 
            '#citation_1' => $citation_1,
            '#test_string' => $this->t('Tesing string for testing purposes')
        ];
    }
}