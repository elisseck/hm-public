<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 4/10/18
 * Time: 4:03 PM
 */

namespace Drupal\thm_user_maker_matcher\Plugin\search_api\processor;

use Drupal\search_api\Processor\FieldsProcessorPluginBase;

/**
 * Makes searches case-insensitive on selected fields.
 *
 * @SearchApiProcessor(
 *   id = "compare_birth_dates",
 *   label = @Translation("Birthdate Comparator"),
 *   description = @Translation("Assists w/performing comparisions on date objects."),
 *   stages = {
 *     "pre_index_save" = 0,
 *     "preprocess_index" = -20,
 *     "preprocess_query" = 0
 *   }
 * )
 */
class CompareBirthDates extends FieldsProcessorPluginBase {

  protected function processFieldValue(&$value, $type) {
    $value = substr($value, 0, -5);
  }
}