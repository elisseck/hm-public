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
use Drupal\search_api\SearchApiException;


class MakerMatcher {

  protected $moduleName = 'thm_user_maker_matcher';

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
  protected $parseStrategy = 'terms';


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

  public function executeSearch(string $fieldValue, string $fieldName) {
    $this->setParseMode();

    $this->query->addCondition($fieldName, ucfirst(strtolower($fieldValue)));

    try {
      return $this->query->execute();
    } catch (SearchApiException $searchApiException) {
      drupal_set_message('An error occurred.');
      \Drupal::logger($this->moduleName)->error($searchApiException->getMessage());
    }
  }

  public function prepareResults(ResultSetInterface $data) {
    /** @var \Drupal\search_api\Item\ItemInterface $item */
    foreach ($data->getResultItems() as $item) {
      yield $item->getOriginalObject()->getValue();
    }
  }
}