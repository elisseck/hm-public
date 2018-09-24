<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 9/24/18
 * Time: 6:17 PM
 */

namespace Drupal\thm_admin_links\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AdminLinksController extends ControllerBase {
  public function export() {
    return new RedirectResponse('/admin/export/users?_format=csv');
  }
}