<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 4/17/18
 * Time: 11:58 AM
 */

namespace Drupal\thm_jwt\Generator;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class THMJWTURLGenerator {

  protected $session;

  /** @var \Drupal\Core\Config\ImmutableConfig  */
  protected $config;

  protected $scienceDAUrl = 'https://smdigital.thehistorymakers.org';

  protected function getJwt($tokenType) {
    return thm_jwt_fetch_token($this->session, $tokenType);
  }

  public function retrieveLink($subDomain, $tokenType) {
    switch ($subDomain) {
      case 'da':
        return $this->config->get('digital_archive_urls.main') . '?jwt=' . $this->getJwt($tokenType);
      case 'smda':
        return $this->config->get('digital_archive_urls.science') . '?jwt=' . $this->getJwt($tokenType);
    }
  }

  public function __construct(SessionInterface $session) {
    $this->session = $session;
    $this->config = \Drupal::config('digital_archive_urls.settings');
  }
}
