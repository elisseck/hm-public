<?php

namespace Drupal\thm_hero_video_player\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Block(
 *   id = "hero_video_player_block",
 *   admin_label = @Translation("THM Hero Video Player Block"),
 *   category = @Translation("THM Hero Video Player Block"),
 * )
 */
class HeroVideoPlayerBlock extends BlockBase {
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['hero_video_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video URL'),
      '#default_value' => isset($config['video_url']) ? $config['video_url'] : ''
    ];

    $form['hero_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video Title'),
      '#default_value' => isset($config['hero_title']) ? $config['hero_title'] : ''
    ];

    $form['hero_desc'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Video Description'),
      '#default_value' => isset($config['hero_desc']) ? $config['hero_desc'] : ''
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('video_url',
      $form_state->getValue('hero_video_url'));
    $this->setConfigurationValue('hero_title',
      $form_state->getValue('hero_title'));
    $this->setConfigurationValue('hero_desc',
      $form_state->getValue('hero_desc'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    return [
      '#theme' => 'angular',
      '#video' => $config['video_url'],
      '#title' => $config['hero_title'],
      '#body' => $config['hero_desc']
    ];
  }

}
