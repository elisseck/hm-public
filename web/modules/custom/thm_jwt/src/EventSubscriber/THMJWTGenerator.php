<?php

namespace Drupal\thm_jwt\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\jwt\Authentication\Event\JwtAuthGenerateEvent;
use Drupal\jwt\Authentication\Event\JwtAuthEvents;
use Drupal\Core\Session\AccountInterface;

/**
 * Class THMJWTGenerator.
 */
class THMJWTGenerator implements EventSubscriberInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The current timezone.
   *
   * @var string
   */
  protected $timeZone;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $user
   *   The current user.
   */
  public function __construct(AccountInterface $user) {
    $this->currentUser = $user;
    $this->timeZone    = date_default_timezone_get();
  }

  /**
   * @{inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[JwtAuthEvents::GENERATE][] = ['generate'];
    return $events;
  }

  /**
   * Determines the level of access.
   *
   * @return string
   */
  protected function getAccess() {
    return in_array('thm_paid_member', $this->currentUser->getRoles()) ? 'All' : 'None';
  }

  /**
   * Sets the server's time zone to UTC.
   *
   * @return bool
   */
  protected function setTimeZoneUTC() {
    return date_default_timezone_set('UTC');
  }

  /**
   * Resets the server's time zone.
   *
   * @return bool
   */
  protected function revertTimeZone() {
    return date_default_timezone_set($this->timeZone);
  }

  /**
   * Sets the JWT expiration time on key `exp`.
   *
   * @param \Drupal\jwt\Authentication\Event\JwtAuthGenerateEvent $event
   */
  protected function modifyExpiration(JwtAuthGenerateEvent $event) {
    $event->removeClaim('exp');
    $this->setTimeZoneUTC();
    $event->addClaim('exp', strtotime('+24 hours'));
    $this->revertTimeZone();
  }

  /**
   * Sets the JWT account name and level of access.
   *
   * @param \Drupal\jwt\Authentication\Event\JwtAuthGenerateEvent $event
   */
  protected function addAcctClaims(JwtAuthGenerateEvent $event) {
    $event->addClaim('username', $this->currentUser->getAccountName());
    $event->addClaim('subscription', $this->getAccess());
  }

  /**
   * Performs the JWT modification.
   *
   * @param \Drupal\jwt\Authentication\Event\JwtAuthGenerateEvent $event
   */
  public function generate(JwtAuthGenerateEvent $event) {
    $event->removeClaim('drupal');

    $this->addAcctClaims($event);
    $this->modifyExpiration($event);
  }

}
