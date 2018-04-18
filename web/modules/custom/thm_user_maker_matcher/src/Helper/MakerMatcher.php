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
   * @var string $parseStrategy
   */
  protected $parseStrategy = 'direct';


  /**
   * @var QueryInterface $query
   */
  protected $query;

  /**
   * @var array $results
   */
  public $results = [];

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
    $parseMode = \Drupal::service($this->searchService)
      ->createInstance($this->parseStrategy);
    $this->query->setParseMode($parseMode);
  }

  public function performSearch(array $values) {
    $this->setParseMode();

    foreach ($values as $fieldName => $fieldValue) {
      $this->executeSearch($fieldValue, $fieldName);
    }
  }

  public function executeSearch(string $fieldValue, string $fieldName) {
    $this->setParseMode();

    if ($fieldName === 'field_birth_date') {
      $this->query->addCondition($fieldName, $fieldValue);
    } else {
      $this->query->addCondition($fieldName, $fieldValue);
    }

    return $this->query->execute();
  }

  public function prepareResults(ResultSetInterface $data, string $field) {

    return array_map(function(ItemInterface $item) use ($field) {
      return @$item->getField($field)->getValues();
    }, $data->getResultItems());

  }
}