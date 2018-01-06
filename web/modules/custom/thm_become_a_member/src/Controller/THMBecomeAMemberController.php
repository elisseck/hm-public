<?php

namespace Drupal\thm_become_a_member\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class THMBecomeAMemberController.
 */
class THMBecomeAMemberController extends ControllerBase {

  public function content() {

    $becomeAMember = '\Drupal\thm_become_a_member\Form\THMBecomeAMemberForm';

    return [
      'form' => $this->formBuilder()->getForm($becomeAMember),
    ];
  }
}
