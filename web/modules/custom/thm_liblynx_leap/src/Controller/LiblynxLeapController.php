<?php

namespace Drupal\thm_liblynx_leap\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LiblynxLeapController extends ControllerBase {

  function __construct($relyingParty='LibLynx', $secret='53f11a94-138f-45db-9a0a-c23d5b528766') {
    $this->relyingParty = $relyingParty;
    $this->secret = $secret;
  }

  private function createHash($string) {
    return hash_hmac('sha256',$string,$this->secret);
  }

	public function get(Request $request) {
		$response['data'] = 'Some test data to return';
		$response['method'] = 'GET';

		return new JsonResponse( $response );
	}

	public function post(Request $request) {

    $validRequest=false;
    $uid=false;
    $roles=false;
    $email='';
    $name='';
    $returnRoles=array();
    $gmdate = new \DateTime("now", new \DateTimeZone("UTC"));

		if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
			$data = json_decode( $request->getContent(), TRUE );
			$request->request->replace( is_array( $data ) ? $data : [] );
		}

    $targetHash=$data['hash'];
    $sourceHash=$this->createHash($data['relyingParty'].$data['username'].$data['password'].$data['timestamp']);

    $validRequest=($targetHash==$sourceHash) ? true : false;

    if ($validRequest) {
      $datetime1 = $gmdate;
      $datetime2 = date_create($data['timestamp']);
      $diff=date_diff($datetime1,$datetime2);
      $validRequest=($diff->h <= 1) ? true : false;
    }

    if ($validRequest) {
      // check username
      $uidQuery = \Drupal::entityQuery('user')
        ->condition('name', $data['username'])
        ->range(0, 1)
        ->execute();
      if(!empty($uidQuery)){
        $uid=array_pop(array_reverse($uidQuery));
      }

      // retreive user information
      if ($uid) {
        $user = \Drupal\user\Entity\User::load($uid);
        $roles = $user->getRoles();
        $email = $user->getEmail();
        $name = $user->getDisplayName();
      }

      // does password match?
      $authenticatedUid = \Drupal::service('user.auth')->authenticate($data['username'], $data['password']);
      if ($uid != $authenticatedUid) {
        $authenticatedUid=false;
      }

      // get roles
      $is_thm_paid_member=array_search('thm_paid_member',$roles);
      $returnRoles[]='SMDA';
      if ($is_thm_paid_member) {
        $returnRoles[]='THMDA';
      }
    }

    $gmdateString=date_format($gmdate,'Y-m-d\TH:i:s');
    $responseHash=$this->createHash($uid.$gmdateString);

    $response['knownuser'] = ($uid != false) ? 'true' : 'false';
    $response['validpassword'] = ($authenticatedUid != false) ? 'true' : 'false';

    $account['id']='thm';
    $account['name']='The HistoryMakers';
    $response['account']=$account;

    $returnUser['id']=$uid;
    $metadata['email']=$email;
    $metadata['name']=$name;
    $returnUser['metadata']=$metadata;
    $response['user']=$returnUser;

    $response['units']=$returnRoles;
		$response['timestamp'] = $gmdateString;
		$response['hash'] = $responseHash;

		return new JsonResponse( $response );
	}
}
