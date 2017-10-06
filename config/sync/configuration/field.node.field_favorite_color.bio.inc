<?php
/**
 * @file
 * field.node.field_favorite_color.bio.inc
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
      'max_length' => '255',
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
            'field_data_field_favorite_color' => array(
              'value' => 'field_favorite_color_value',
              'format' => 'field_favorite_color_format',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_favorite_color' => array(
              'value' => 'field_favorite_color_value',
              'format' => 'field_favorite_color_format',
            ),
          ),
        ),
      ),
    ),
    'field_name' => 'field_favorite_color',
    'type' => 'text',
    'module' => 'text',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'value' => array(
        'type' => 'varchar',
        'length' => '255',
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
        'weight' => '18',
        'settings' => array(),
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => '0',
      ),
    ),
    'label' => 'Favorite Color',
    'required' => 0,
    'settings' => array(
      'text_processing' => '0',
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'size' => '60',
      ),
      'type' => 'text_textfield',
      'weight' => '6',
    ),
    'field_name' => 'field_favorite_color',
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
