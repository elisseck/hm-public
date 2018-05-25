<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 3/29/18
 * Time: 10:17 AM
 */

namespace Drupal\thm_jwt\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Session\AccountInterface;

class THMURLListener implements EventSubscriberInterface {

  /**
   * @var AccountInterface $currentUser
   */
  protected $currentUser;

  /**
   * THMURLListener constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $user
   */
  public function __construct(AccountInterface $user) {
    $this->currentUser = $user;
  }

  /**
   * @{inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::FINISH_REQUEST] = [ 'handle', 500 ];
    return $events;
  }

  protected function isAQualifyingUrl(string $url) {
    return thm_jwt_request_has_return_url($url) &&
      thm_jwt_url_has_jwt_entry($url) &&
      $this->currentUser->isAuthenticated();
  }

  public function handle(KernelEvent $event) {
    $request    = $event->getRequest();
    $requestUri = $request->getRequestUri();

    if ($this->isAQualifyingUrl($requestUri)) {
      $session  = $request->getSession();

      if (strpos($requestUri, '%3D') !== false) {
        $url = urldecode(explode('=', $requestUri)[1]);
      } else {
        $url = explode('return=', $requestUri)[1];
      }

      $token    = thm_jwt_fetch_token($session);
      if ((thm_jwt_url_has_jwt_entry($url))) {
        $freshUrl = thm_jwt_refresh_url($url, $token);
      } else {
        $freshUrl = urldecode(explode('return=', $url)[0]) . '?jwt=' . $token;
      }

      thm_jwt_redirect_to_return_url($freshUrl);
    }
  }

}