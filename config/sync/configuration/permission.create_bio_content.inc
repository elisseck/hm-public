<?php
/**
 * @file
 * permission.create_bio_content.inc
 */

$api = '2.0.0';

$data = array(
  'permission' => 'create bio content',
  'roles' => array(),
);

$dependencies = array(
  'content_type.bio' => 'content_type.bio',
);

$optional = array();

$modules = array(
  0 => 'node',
);
