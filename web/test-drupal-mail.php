<?php

function bio_import_xml_mail($key, &$message, $params) {
	$options = [
		'langcode' => $message['langcode']
	];

	switch($key) {
	  case 'import_complete':
		  $message['from'] = \Drupal::config('system.site')->get('mail');
		  $message['subject'] = 'testing';
		  $message['body'][] = $params['message'];
		  break;
	}
}


$mailManager = \Drupal::service('plugin.manager.mail');
$module = 'bio_import_xml';
$key = 'import_complete';
$to = 'tony.taylor@thirdwavellc.com';
$params['message'] = 'hello mr. mailman!';
$params['subject'] = 'just testing around';
$params['node_title'] = 'what title?';
$langcode = 'en';
$send = true;
$result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
