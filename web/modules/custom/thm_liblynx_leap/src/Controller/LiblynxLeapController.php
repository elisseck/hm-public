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
    $username='';
    $returnRoles=array();
    $gmdate = new \DateTime("now", new \DateTimeZone("UTC"));

		if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
			$data = json_decode( $request->getContent(), TRUE );
			$request->request->replace( is_array( $data ) ? $data : [] );
		}

    // check username
    $uidQuery = \Drupal::entityQuery('user')
      ->condition('name', $data['username'])
      ->range(0, 1)
      ->execute();
    if(!empty($uidQuery)){
      $uid=array_pop(array_reverse($uidQuery));
    }
    else {
      // check email then
      $uidQuery = \Drupal::entityQuery('user')
        ->condition('mail', $data['username'])
        ->range(0, 1)
        ->execute();
      if(!empty($uidQuery)){
        $uid=array_pop(array_reverse($uidQuery));
      }
    }

    // retreive user information
    if ($uid) {
      $user = \Drupal\user\Entity\User::load($uid);
      $roles = $user->getRoles();
      $email = $user->getEmail();
      $name = $user->getDisplayName();
      $username = $user->getUsername();

      // get roles
      $is_thm_paid_member=array_search('thm_paid_member',$roles);
      $returnRoles[]='SMDA';
      if ($is_thm_paid_member) {
        $returnRoles[]='THMDA';
      }
    }

    // does password match?
    $authenticatedUid = \Drupal::service('user.auth')->authenticate($username, $data['password']);
    if ($uid != $authenticatedUid) {
      $authenticatedUid=false;
    }

    // check authenticty of request
    $targetHash=$data['hash'];
    $sourceHash=$this->createHash($data['relyingParty'].$data['username'].$data['password'].$data['timestamp']);
    $validRequest=($targetHash==$sourceHash) ? true : false;

    if ($validRequest) {
      $datetime1 = $gmdate;
      $datetime2 = date_create($data['timestamp']);
      $diff=date_diff($datetime1,$datetime2);
      $validRequest=($diff->d <= 1) ? true : false;
    }

    if ($validRequest==false) {
      $validpassword=false;
    }

    $knownuser=($uid != false) ? true : false;
    $validpassword=($authenticatedUid != false) ? true : false;

    $response['knownuser'] = $knownuser;
    $response['validpassword'] = $validpassword;

    if ($knownuser) {
      if ($validpassword) {
        $gmdateString=date_format($gmdate,'Y-m-d\TH:i:s');
        $responseHash=$this->createHash($uid.$gmdateString);

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
      }
      else {
        $response['resetUrl']='https://www.thehistorymakers.org/user/password';
      }
    }

		return new JsonResponse( $response );
	}
}
