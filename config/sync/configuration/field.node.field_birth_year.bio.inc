<?php
/**
 * @file
 * field.node.field_birth_year.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'translatable' => '1',
    'entity_types' => array(),
    'settings' => array(
      'code' => '$entity_field[0][\'value\'] = date(\'Y\', strtotime($entity->field_birth_date[LANGUAGE_NONE][0][\'value\']));',
      'display_format' => '$display_output = $entity_field_item[\'value\'];',
      'store' => 1,
      'database' => array(
        'data_type' => 'varchar',
        'data_length' => '32',
        'data_size' => 'normal',
        'data_precision' => '10',
        'data_scale' => '2',
        'data_default' => '',
        'data_not_NULL' => 0,
        'data_index' => 0,
      ),
    ),
    'storage' => array(
      'type' => 'field_sql_storage',
      'settings' => array(),
      'module' => 'field_sql_storage',
      'active' => '1',
      'details' => array(
        'sql' => array(
          'FIELD_LOAD_CURRENT' => array(
            'field_data_field_birth_year' => array(
              'value' => 'field_birth_year_value',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_birth_year' => array(
              'value' => 'field_birth_year_value',
            ),
          ),
        ),
      ),
    ),
    'foreign keys' => array(),
    'indexes' => array(),
    'field_name' => 'field_birth_year',
    'type' => 'computed',
    'module' => 'computed_field',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'value' => array(
        'type' => 'varchar',
        'length' => '32',
        'not null' => 0,
      ),
    ),
  ),
  'field_instance' => array(
    'label' => 'Birth Year',
    'widget' => array(
      'type' => 'computed',
      'weight' => '32',
      'settings' => array(),
      'module' => 'computed_field',
    ),
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'display' => array(
      'default' => array(
        'label' => 'above',
        'type' => 'hidden',
        'weight' => '52',
        'settings' => array(),
      ),
      'teaser' => array(
        'type' => 'hidden',
        'label' => 'above',
        'settings' => array(),
        'weight' => 0,
      ),
    ),
    'required' => FALSE,
    'description' => '',
    'field_name' => 'field_birth_year',
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
  1 => 'computed_field',
);
