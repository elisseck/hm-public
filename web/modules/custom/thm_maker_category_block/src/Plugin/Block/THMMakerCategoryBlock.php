<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 11/7/18
 * Time: 3:59 PM
 */

namespace Drupal\thm_maker_category_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\taxonomy\Entity\Term;
use Drupal\file\Entity\File;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Database\StatementInterface;
use Drupal\Core\Database\Connection;


/**
 * Class THMMakerCategoryBlock
 *
 * @package Drupal\thm_maker_category_block\Plugin\Block
 *
 * @Block(
 *   id = "thm_maker_block",
 *   admin_label = @Translation("THM Maker Category Block"),
 *   category = @Translation("Maker Category")
 * )
 */
class THMMakerCategoryBlock extends BlockBase {

  protected $db;

  /**
   * @return EntityInterface[]|Term[]
   */
  protected function getMakerCategories() {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', 'maker_category')
      ->sort('weight');
    $tids  = $query->execute();
    return Term::loadMultiple($tids);
  }

  /**
   * Retrieve all fids (file ids) and relative titles for biographies for a
   * given category id (taxonomy term id)
   *
   * @param $categoryId
   * @param \Drupal\Core\Database\Connection $db
   *
   * @return \Drupal\Core\Database\StatementInterface|int|null
   */
  protected function getCategoryData($categoryId, Connection $db) {
    $stmt = <<<SQL
SELECT image.field_bio_image_target_id AS fid, details.title
FROM
    node
    INNER JOIN {node__field_maker_category} maker ON node.nid = maker.entity_id
    INNER JOIN {node__field_bio_image} image ON node.nid = image.entity_id
    INNER JOIN {node_field_data} details ON node.nid = details.nid
WHERE
    node.type = :type AND
    maker.field_maker_category_target_id = :category
SQL;

    return $db->query($stmt, [ ':type' => 'bio', ':category' => $categoryId ]);
  }

  /**
   * Fetches a random item from the collection of data returned.
   *
   * @param int $makerCategoryId
   *
   * @return mixed
   */
  protected function getRandomObject(int $makerCategoryId) {
    $results = $this->getCategoryData($makerCategoryId, $this->db);
    $data = $results->fetchAll();
    $idx = mt_rand(0, (count($data) - 1));
    return $data[$idx];
  }

  /**
   * @param $fid
   * @param \Drupal\Core\Database\Connection $db
   *
   * @return mixed
   * @deprecated
   */
  protected function getPath($fid, Connection $db) {
    $stmt = <<<SQL
SELECT uri FROM {file_managed} WHERE fid = :fid
SQL;
    return $db->query($stmt, [ ':fid' => $fid ])->fetchCol()[0];
  }

  protected function getImagePath($fid) {
    if (!$fid || is_null($fid)) return false;

    $file = File::load($fid);

    return file_url_transform_relative(file_create_url($file->getFileUri()));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $this->db = \Drupal::database();

    $results = $this->getMakerCategories();

    // annoying hack entered because the data is `unclean`
    $results = array_filter($results, function(Term $result) {
      return !in_array($result->getName(), ['EducationMaker', 'CivicMaker']);
    });

    $makerCats = array_map(function(Term $result) {
      $record = $this->getRandomObject($result->id());

      return [
        'maker_category_id' => $result->id(),
        'maker_category_name' => $result->getName(),
        'maker_category_desc' => $result->getDescription(),
        'current_maker_img_name' => $record->title,
        'maker_category_img' => $this->getImagePath($record->fid)
      ];
    }, $results);

    return [
      '#theme' => 'thm_maker_category_block',
      '#data' => $makerCats,
      '#cache' => [ 'max-age' => 0 ]
    ];
  }
}
