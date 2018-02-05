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
use Drupal\Core\Render\Renderer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\views\ViewExecutable;


class RMController extends ControllerBase {

  /**
   * @var Renderer
   */
  protected $renderer;

  public function __construct(Renderer $renderer) {
    $this->renderer = $renderer;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('renderer')
    );
  }

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
   * Extracts terms from a node to be used as parameters in embedded views.
   *
   * @param Node $node
   *
   * @return array
   */
  public function getSearchTerms(Node $node): array {
    return [
      'favorite_color' => $node->get('field_favorite_color')->value,
      'birthplace'     => $node->get('field_birth_place_term')->getValue(),
      'occupation'     => $node->get('field_occupation')->getValue(),
      'education'      => $node->get('field_schools')->getValue()
    ];
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

    $node  = $this->getNode($nid);
    $terms = $this->getSearchTerms($node);

    /** @var ViewExecutable $colorView */
    $colorView = \Drupal\views\Views::getView('related_makers_by_color');


    $build['related_content'] = [];

    $build['related_content']['by_birthplace'] = [];
    $build['related_content']['by_color'] = $colorView->buildRenderable('block_1', [$terms['favorite_color']]);
    $build['related_content']['by_occupation'] = [];
    $build['related_content']['by_education'] = [];

    return $build;
  }
}