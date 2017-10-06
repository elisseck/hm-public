<?php
/**
 * @file
 * field.node.field_speakers_bureau_honorarium.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'entity_types' => array(),
    'foreign keys' => array(
      'format' => array(
        'columns' => array(
          'format' => 'format',
        ),
        'table' => 'filter_format',
      ),
    ),
    'indexes' => array(
      'format' => array(
        0 => 'format',
      ),
    ),
    'settings' => array(
      'profile2_private' => FALSE,
    ),
    'translatable' => '1',
    'storage' => array(
      'type' => 'field_sql_storage',
      'settings' => array(),
      'module' => 'field_sql_storage',
      'active' => '1',
      'details' => array(
        'sql' => array(
          'FIELD_LOAD_CURRENT' => array(
            'field_data_field_speakers_bureau_honorarium' => array(
              'value' => 'field_speakers_bureau_honorarium_value',
              'format' => 'field_speakers_bureau_honorarium_format',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_speakers_bureau_honorarium' => array(
              'value' => 'field_speakers_bureau_honorarium_value',
              'format' => 'field_speakers_bureau_honorarium_format',
            ),
          ),
        ),
      ),
    ),
    'field_name' => 'field_speakers_bureau_honorarium',
    'type' => 'text_long',
    'module' => 'text',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'value' => array(
        'type' => 'text',
        'size' => 'big',
        'not null' => FALSE,
      ),
      'format' => array(
        'type' => 'varchar',
        'length' => 255,
        'not null' => FALSE,
      ),
    ),
  ),
  'field_instance' => array(
    'default_value' => NULL,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'type' => 'hidden',
        'weight' => '10',
        'settings' => array(),
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'label' => 'Speakers Bureau Honorarium',
    'required' => 0,
    'settings' => array(
      'text_processing' => '0',
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'rows' => '5',
      ),
      'type' => 'text_textarea',
      'weight' => '46',
    ),
    'field_name' => 'field_speakers_bureau_honorarium',
    'entity_type' => 'node',
    'bundle' => 'bio',
    'deleted' => '0',
  ),
);

$dependencies = array(
  'content_type.bio' => 'content_type.bio',
);

$optional = array();

$modules = array(
  0 => 'field_sql_storage',
  1 => 'text',
);
