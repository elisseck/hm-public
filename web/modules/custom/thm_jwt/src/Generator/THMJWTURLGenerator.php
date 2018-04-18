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

  protected $digitalArchiveUrl = 'https://auth-test-client.azurewebsites.net';

  protected $scienceDAUrl = 'https://smda.thehistorymakers.org';

  protected function getJwt() {
    return thm_jwt_fetch_token($this->session);
  }

  public function retrieveLink($subDomain = 'da') {
    switch ($subDomain) {
      case 'da':
        return $this->digitalArchiveUrl . '/jwt?=' . $this->getJwt();
      case 'smda':
        return $this->scienceDAUrl . '/jwt?=' . $this->getJwt();
    }
  }

  public function __construct(SessionInterface $session) {
    $this->session = $session;
  }
}