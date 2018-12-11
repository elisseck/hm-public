<?php

namespace Drupal\page_banner\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Connection;
use Drupal\Core\Database\StatementInterface;

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

  /**
   * @param $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return array
   */
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

  /**
   * (Attempts to) retrieve an image. Returns false if no image is found.
   *
   * @param $fid
   *
   * @return bool|string
   */
  protected function getImagePath($fid) {
    if (!$fid || is_null($fid)) return false;

    $file = \Drupal\file\Entity\File::load($fid);

    return file_url_transform_relative(file_create_url($file->getFileUri()));
  }

  protected function getTermIdFromName(string $termName) {
    $storage = \Drupal::service('entity.manager')->getStorage('taxonomy_term');

    /** @var \Drupal\taxonomy\Entity\Term $t */
    $t = $storage->loadByProperties([
      'name' => $termName,
      'vid' => 'maker_category'
    ]);

    return key($t);
  }

  protected function getTermNameFromBioViewUrl(string $url) {
    $urlParts = explode('/', $url);
    return $urlParts[count($urlParts) - 1];
  }

  /**
   * Retrieve all fids (file ids) for biographies for a given category id
   * (taxonomy term id)
   *
   * @param $categoryId
   * @param Connection $db
   *
   * @return StatementInterface|int|null
   */
  protected function getFidsForCategory($categoryId, Connection $db) {
    $stmt = <<<SQL
SELECT image.field_bio_image_target_id
FROM
    node
    INNER JOIN {node__field_maker_category} maker ON node.nid = maker.entity_id
    INNER JOIN {node__field_bio_image} image ON node.nid = image.entity_id
WHERE
    node.type = :type AND
    maker.field_maker_category_target_id = :category
SQL;

    return $db->query($stmt, [ ':type' => 'bio', ':category' => $categoryId ]);
  }

  /**
   * @param int $makerCategoryId
   *
   * @return int
   */
  protected function getRandomFid(int $makerCategoryId) {
    $fids = $this->getFidsForCategory($makerCategoryId, \Drupal::database());

    $listOfFids = $fids->fetchCol();
    $idx = mt_rand(0, (count($listOfFids) - 1));
    return $listOfFids[$idx];
  }

  /**
   * @return Int[]
   */
  protected function getMakerCategoryIds() {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', 'maker_category')
      ->sort('weight');
    $tids  = $query->execute();
    return array_keys($tids);
  }

  protected function getRandomCategoryId($categoryIds) {
    // WARNING: Stupid hack!
    $cleanTids = array_filter($categoryIds, function($tid) {
      return !in_array($tid, [701568, 701978]);
    });
    $randomIdx = mt_rand(0, count($cleanTids) - 1);
    return $cleanTids[$randomIdx];
  }

  /**
   * Used specifically for images/files--makes sure this isn't treated as
   * a temporary file (these are automatically deleted after six hours).
   *
   * @param $fid
   *
   * @return bool
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function permanentify($fid) {
    if (!$fid || is_null($fid)) return false;
    $file = \Drupal\file\Entity\File::load($fid);

    $file->setPermanent();
    $file->save();
    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $msg = 'An error occurred attempting to load or save an image: ';

    if (!empty($values['highlight_section_image'])) {
      try {
        $this->permanentify($values['highlight_section_image'][0]);
      } catch (EntityStorageException $exc) {
        \Drupal::logger('page_banner')->error($msg . $exc->getMessage());
        drupal_set_message($msg . ' <br>Please check the dblog for more information');
        return false;
      }

      $this->setConfigurationValue('highlight_section_image', $values['highlight_section_image']);
    } else {
      $this->setConfigurationValue('highlight_section_image', '');
    }
    if (!empty($values['background_image'])) {
      try {
        $this->permanentify($values['background_image'][0]);
      } catch (EntityStorageException $exc) {
        \Drupal::logger('page_banner')->error($msg . $exc->getMessage());
        drupal_set_message($msg . ' <br>Please check the dblog for more information');
        return false;
      }

      $this->setConfigurationValue('background_image', $values['background_image']);
    } else {
      $this->setConfigurationValue('background_image', '');
    }
    $this->setConfigurationValue('background_color', $values['background_color']);   
    $this->setConfigurationValue('highlight_section', $form_state->getValue('highlight_section')); 
    $this->setConfigurationValue('highlight_section_name', $form_state->getValue('highlight_section_name'));   
    $this->setConfigurationValue('feature_occupation', $form_state->getValue('feature_occupation'));

    return true;
  }

  /**
   * Determines how to extract a value given a configuration object and a key.
   *
   * @param $config
   * @param $value
   *
   * @return bool|string
   */
  public function existy($config, $value) {
    if (array_key_exists($value, $config)) {
      if (is_array($config[$value]) && count($config[$value]) > 0) {
        return $this->getImagePath($config[$value][0]);
      } else {
        return $config[$value];
      }
    }

    return false;
  }

  /**
   * @param array $config
   *
   * @return bool|string
   */
  public function loadImageResource(array $config) {
    if ($imgPath = $this->existy($config, 'highlight_section_image')) {
      return $imgPath;
    } else {
      $termName = $this->getTermNameFromBioViewUrl(
        Url::fromRoute('<current>')->toString());

      if ($termName === 'biographies') {
        $fid = $this->getRandomFid(
          $this->getRandomCategoryId($this->getMakerCategoryIds()));
      } else {
        $fid = $this->getRandomFid($this->getTermIdFromName($termName));
      }

      return $this->getImagePath($fid);
    }
  }

  /**
   * Responsible for placing configuration data into the twig for rendering.
   *
   * @return array
   */
  public function build() {
    $config = $this->getConfiguration();
    
    return [
      '#theme' => 'page_banner',
      '#cache' => [ 'max-age' => 0 ],
      '#banner_data' => [
        'background_color' => $this->existy($config, 'background_color'), 
        'background_image' => $this->existy($config, 'background_image'), 
        'highlight_section' => $this->existy($config, 'highlight_section'), 
        'highlight_section_name' => $this->existy($config, 'highlight_section_name'),       
        'highlight_section_image' => $this->loadImageResource($config),
        'feature_occupation' => $this->existy($config, 'feature_occupation'),
      ]
    ];
  }

} //The End
