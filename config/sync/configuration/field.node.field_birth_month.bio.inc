<?php
/**
 * @file
 * field.node.field_birth_month.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'entity_types' => array(),
    'foreign keys' => array(),
    'indexes' => array(),
    'settings' => array(
      'code' => '$entity_field[0][\'value\'] = date(\'F\', strtotime($entity->field_birth_date[LANGUAGE_NONE][0][\'value\']));',
      'database' => array(
        'data_default' => '',
        'data_index' => 0,
        'data_length' => '128',
        'data_not_NULL' => 0,
        'data_precision' => '10',
        'data_scale' => '2',
        'data_size' => 'normal',
        'data_type' => 'varchar',
      ),
      'display_format' => '$display_output = $entity_field_item[\'value\'];',
      'store' => 1,
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
            'field_data_field_birth_month' => array(
              'value' => 'field_birth_month_value',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_birth_month' => array(
              'value' => 'field_birth_month_value',
            ),
          ),
        ),
      ),
    ),
    'field_name' => 'field_birth_month',
    'type' => 'computed',
    'module' => 'computed_field',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'value' => array(
        'type' => 'varchar',
        'length' => '128',
        'not null' => 0,
      ),
    ),
  ),
  'field_instance' => array(
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'type' => 'hidden',
        'weight' => '14',
        'settings' => array(),
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'label' => 'Birth Month',
    'required' => FALSE,
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'module' => 'computed_field',
      'settings' => array(),
      'type' => 'computed',
      'weight' => '50',
    ),
    'field_name' => 'field_birth_month',
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
