<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 5/22/18
 * Time: 9:50 AM
 */

namespace Drupal\thm_adv_search\Controller;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\facets\FacetInterface;
use Drupal\facets\FacetManager\DefaultFacetManager;
use Drupal\facets\Result\ResultInterface;
use Drupal\taxonomy\Entity\Term;



class AutocompleteController extends ControllerBase {

  /** @var DefaultFacetManager $facetMgr */
  protected $facetMgr;

  protected $cacheIdBase = 'cache_facet_data_';

  protected function getCacheMgr() {
    return \Drupal::cache();
  }

  protected function getFacetsMgr() {
    return \Drupal::service('facets.manager');
  }

  protected function getFacets() {
    return $this->facetMgr->getEnabledFacets();
  }

  protected function getFacet($facet_id) {
    return $this->getFacets()[$facet_id];
  }

  protected function removeFromCache() {
    return null; // TODO: implement cache removal method
  }

  protected function cachedFacetFound($facet_id) {
    return $this->getCacheMgr()->get($this->cacheIdBase . $facet_id);
  }

  protected function buildOutput($results, FacetInterface $facet) {
    $output = [];
    /** @var ResultInterface $result */
    foreach ($results as $result) {
      $v = $result->getDisplayValue();

      $output[] = [
        'name' => (is_numeric($v)) ? Term::load($v)->get('name')->value : $v,
        'value' => urlencode($facet->id() . ':' . $result->getRawValue())
      ];
    }
    return $output;
  }

  public function fetch($facet_id) {
    $this->facetMgr = $this->getFacetsMgr();
    $facetSource = 'search_api:views_page__advanced_search__page_1';

    $this->facetMgr->updateResults($facetSource);
    $facet = $this->facetMgr->returnProcessedFacet($this->getFacet($facet_id));

    if (!$this->cachedFacetFound($facet_id)) {
      $output = $this->buildOutput($facet->getResults(), $facet);
      $this->getCacheMgr()->set($this->cacheIdBase . $facet_id,
        $output, CacheBackendInterface::CACHE_PERMANENT);
    } else {
      $output = $this->getCacheMgr()->get($this->cacheIdBase . $facet_id);
    }


    return new JsonResponse($output->data);
  }
}