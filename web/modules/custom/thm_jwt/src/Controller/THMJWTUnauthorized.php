<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 3/26/18
 * Time: 12:45 PM
 */

namespace Drupal\thm_jwt\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;

class THMJWTUnauthorized extends ControllerBase {

  protected $account;

  protected $request;

  protected function getReferer(Request $request) {
    $headers = $request->server->getHeaders();
    return isset($headers['HTTP_REFERER']) ? $headers['HTTP_REFERER'] : '';
  }

  protected function getUserRole(AccountInterface $account) {
    $user = User::load($account->id());
    $roles = $user->getRoles();
    return $roles;
  }

  public function __construct(Request $request) {
    $this->request = $request;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')->getCurrentRequest()
    );
  }

  protected function writeToLog() {

    $errorMsg = 'access to @address by user @user of role(s) @role at @source failed.';

    $this->getLogger('thm_da_auth')
      ->error($errorMsg,
        [ '@address' => $this->getReferer($this->request),
          '@user' => $this->currentUser()->getAccountName(),
          '@role' => print_r($this->getUserRole($this->currentUser()), true),
          '@source' => $this->request->getClientIp() ]);
  }

  public function content() {
    $this->writeToLog();

    return [
      '#theme' => 'thm_jwt'
    ];
  }
}
