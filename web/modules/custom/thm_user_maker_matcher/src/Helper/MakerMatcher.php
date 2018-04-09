<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 4/9/18
 * Time: 10:32 AM
 */

namespace Drupal\thm_user_maker_matcher\Helper;

use Drupal\search_api\Entity\Index;
use Drupal\search_api\Query\QueryInterface;
use Drupal\search_api\Query\ResultSetInterface;
use Drupal\search_api\Item\ItemInterface;


class MakerMatcher {

  /**
   * @var string $indexName
   */
  protected $indexName = 'biography_index';

  /**
   * @var string $searchService
   */
  protected $searchService = 'plugin.manager.search_api.parse_mode';


  /**
   * @var QueryInterface
   */
  protected $query;

  protected $results = [];

  /**
   * MakerMatcher constructor.
   */
  public function __construct() {
    $this->query = $this->createQuery();
  }

  /**
   * @return mixed
   */
  protected function createQuery() {
    return Index::load($this->indexName)->query();
  }

  protected function setParseMode() {
    $parseMode = \Drupal::service($this->searchService)->createInstance('direct');
    $this->query->setParseMode($parseMode);
  }

  public function performSearch(array $values) {
    $this->setParseMode();
    $this->query->setFulltextFields([
      'field_favorite_season',
      'field_favorite_food',
      'field_favorite_color',
      'field_birth_date'
    ]);

    foreach ($values as $fieldName => $fieldValue) {
      $this->executeSearch($fieldValue, $fieldName);
    }
  }

  protected function executeSearch(string $term, string $field) {
    $this->query->keys($term);
    $this->results[$field] = $this->query->execute();
  }

  public function prepareResults() {
    $items = $this->results;
    return $items;

    /*return array_map(function(ItemInterface $item) {
      return [
        'favorite_season' => [ @$item->getField('field_favorite_season')->getValues() ]
      ];
    }, $items);*/
  }
}