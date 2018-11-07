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
   * @return mixed
   */
  protected function getRandomFid(int $makerCategoryId) {
    $fids = $this->getFidsForCategory($makerCategoryId, $this->db);

    $listOfFids = $fids->fetchCol();
    $idx = mt_rand(0, (count($listOfFids) - 1));
    return $listOfFids[$idx];
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

    $makerCats = array_map(function(Term $result) {
      return [
        'maker_category_id' => $result->id(),
        'maker_category_name' => $result->getName(),
        'maker_category_desc' => $result->getDescription(),
        'maker_category_img' => $this->getImagePath($this->getRandomFid($result->id()))
      ];
    }, $results);

    return [
      '#theme' => 'thm_maker_category_block',
      '#data' => $makerCats,
      '#cache' => [ 'max-age' => 0 ]
    ];
  }
}
