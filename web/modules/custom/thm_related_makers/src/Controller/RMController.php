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
use Drupal\taxonomy\Entity\Term;


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
      'employment'     => $node->get('field_employment')->getValue(),
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

  protected function tidToName(int $termId) {
    return Term::load($termId)->getName();
  }

  protected function convertTermIdsToTermNames(array $terms) {
    $output = [];
    foreach ($terms as $key => $term) {
      $output[$key] = implode(',', array_map(function($tid){
        return $this->tidToName($tid['target_id']);
      }, $term));
    }
    return $output;
  }

  /**
   * Page content processor.
   *
   * @param int $nid
   *
   * @return array Render array
   */
  public function content(int $nid): array {

    $node   = $this->getNode($nid);
    $terms  = $this->getSearchTerms($node);
    $values = $this->convertTermIdsToTermNames([
      'birth_place' => $terms['birthplace'],
      'occupation'  => $terms['occupation']
    ]);

    return [
      '#theme' => 'thm_related_makers_full_page',
      '#data' => [
        'favorite_color' => $terms['favorite_color'],
        'employment'     => @$terms['employment'][0]['value'],
        'birth_place'    => $this->flattenValues($terms['birthplace'], 'target_id'),
        'birthplace_str' => $values['birth_place'],
        'occupation'     => $this->flattenValues($terms['occupation'], 'target_id'),
        'occupation_str' => $values['occupation'],
        'education'      => @$terms['education'][0]['value']
      ]
    ];
  }
}
