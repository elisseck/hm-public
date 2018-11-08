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
use Drupal\views\Views;
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

  protected function flattenValues(array $data, string $key) {
    $output = [];
    foreach ($data as $datum) {
      array_push($output, $datum[$key]);
    }
    return implode(',', $output);
  }

  /**
   * Page content processor.
   *
   * @param int $nid
   *
   * @return array Render array
   */
  public function content(int $nid): array {

    $node  = $this->getNode($nid);
    $terms = $this->getSearchTerms($node);

    // TODO: Refactor the `Education`(Schools) view to handle multiple arguments.
    return [
      '#theme' => 'thm_related_makers_full_page',
      '#data' => [
        'favorite_color' => $terms['favorite_color'],
        'birth_place'    => $this->flattenValues($terms['birthplace'], 'target_id'),
        'occupation'     => $this->flattenValues($terms['occupation'], 'target_id'),
        'education'      => $terms['education'][0]['value']
      ]
    ];
  }
}
