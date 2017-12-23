<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 12/19/17
 * Time: 4:01 PM
 */

namespace Drupal\thm_related_makers\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;


class RMController extends ControllerBase {

  /**
   * Retrives a node given a node id (nid).
   *
   * @param int $nid
   *
   * @return \Drupal\node\Entity\Node
   */
  protected function getNode(int $nid): Node {
    return Node::load($nid);
  }

  /**
   * Returns a string to be used as the page title.
   *
   * @param int $nid
   *
   * @return string
   */
  public function setTitle(int $nid): string {
    return "Related to " . $this->getNode($nid)->getTitle();
  }

  /**
   * Page content processor.
   *
   * @param int $nid
   *
   * @return array Render array
   * @throws \Drupal\search_api\SearchApiException
   */
  public function content(int $nid): array {

    $node = $this->getNode($nid);
    $results = thm_related_makers_perform_search($node, false, 50);

    return [
      '#cache' => [ 'max-age' => 0 ],
      '#theme' => 'thm_related_makers_full_page',
      '#data' => $results['data']
    ];
  }
}