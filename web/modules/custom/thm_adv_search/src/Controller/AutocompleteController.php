<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 5/22/18
 * Time: 9:50 AM
 */

namespace Drupal\thm_adv_search\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Tags;
use Drupal\Component\Utility\Unicode;


class AutocompleteController extends ControllerBase {
  public function manage(Request $request, $field_name, $count) {
    $output = [];

    if ($input = $request->query->get('q')) {
      for ($i = 0; $i < $count; $i++) {
        $output[] = [
          'value' => $field_name . '_' . $i . '(' . $i . ')',
          'label' => $field_name . ' ' . $i
        ];
      }
    }

    return new JsonResponse($output);
  }
}