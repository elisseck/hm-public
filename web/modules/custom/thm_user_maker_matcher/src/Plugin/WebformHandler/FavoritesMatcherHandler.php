<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 4/30/18
 * Time: 10:48 AM
 */

namespace Drupal\thm_user_maker_matcher\Plugin\WebformHandler;

use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface as WSI;
use Drupal\Core\Form\FormStateInterface as FSI;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\taxonomy\Entity\Term;
use Drupal\thm_user_maker_matcher\Helper\MakerMatcher;

/**
 * Form submission handler.
 *
 * Takes submission values and performs a search, potentially matching against
 * Biographies.
 *
 * @WebformHandler(
 *   id = "thm_user_favorites_matcher_handler",
 *   label = @Translation("FavoritesMatcher Handler"),
 *   category = @Translation("Search"),
 *   description = @Translation("Performs matchmaking operations"),
 *   cardinality =
 *   \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_IGNORED,
 *   submission =
 *   \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_OPTIONAL,
 * )
 */
class FavoritesMatcherHandler extends WebformHandlerBase {
  protected function collectFormData(array &$form, FSI $formState) {
    $vs = $formState->getValues();
    return [
      'field_name'  => $vs['favorite_choice_category'],
      'field_value' => $vs['favorite_choice_search_term'],
    ];
  }

  protected function getImageData($record) {
    $v = @$record->getValue()[0];

    if (isset($v)) {
      return [
        'path' => (array_key_exists('target_id', $v)) ? File::load($v['target_id'])
          ->getFileUri() : '',
        'width' => $v['width'],
        'height' => $v['height'],
      ];
    } else {
      return [];
    }
  }

  protected function getRoles($record) {
    $vs = $record->getValue();
    $output = [];

    foreach ($vs as $v) {
      array_push($output, Term::load($v['target_id'])->getName());
    }

    return $output;
  }

  protected function pack(\Generator $data) {
    $output = [];

    /** @var \Drupal\node\NodeInterface $item */
    for ($i = 0; $i <= 9; $i++) {
      $item = $data->current();

      $url = Url::fromRoute('entity.node.canonical',
        ['node' => $item->id()])->toString();

      array_push($output, [
        'url'   => $url,
        'title' => $item->getTitle(),
        'image' => $this->getImageData($item->get('field_bio_image')),
        'roles' => $this->getRoles($item->get('field_occupation')),
      ]);

      $data->next();
    }

    return $output;
  }

  public function submitForm(array &$form, FSI $formState, WSI $webformSubmission) {
    $values  = $this->collectFormData($form, $formState);
    $matcher = new MakerMatcher();
    $results = $matcher->executeSearch($values['field_value'], $values['field_name']);
    $data    = $matcher->prepareResults($results);

    $webformSubmission->setElementData('favorite_choice_results', [
      '#theme'        => 'thm_user_maker_matcher',
      '#result_count' => $results->getResultCount(),
      '#data'         => $this->pack($data)
    ]);
  }
}