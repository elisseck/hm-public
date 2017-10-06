<?php
/**
 * @file
 * permission.edit_own_bio_content.inc
 */

$api = '2.0.0';

$data = array(
  'permission' => 'edit own bio content',
  'roles' => array(
    0 => 'editor',
  ),
);

$dependencies = array(
  'content_type.bio' => 'content_type.bio',
);

$optional = array();

$modules = array(
  0 => 'node',
);
