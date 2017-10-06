<?php
/**
 * @file
 * field.node.field_employer.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'entity_types' => array(),
    'foreign keys' => array(),
    'indexes' => array(),
    'settings' => array(
      'code' => 'foreach ($entity->field_employment[LANGUAGE_NONE] as $index => $value) {
  $entity_field[$index][\'value\'] =  trim(substr($value[\'value\'], 0, strpos($value[\'value\'], \';\')));
}',
      'database' => array(
        'data_default' => '',
        'data_index' => 0,
        'data_length' => '256',
        'data_not_NULL' => 0,
        'data_precision' => '10',
        'data_scale' => '2',
        'data_size' => 'normal',
        'data_type' => 'text',
      ),
      'display_format' => '$display_output = $entity_field_item[\'value\'];',
      'profile2_private' => FALSE,
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
            'field_data_field_employer' => array(
              'value' => 'field_employer_value',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_employer' => array(
              'value' => 'field_employer_value',
            ),
          ),
        ),
      ),
    ),
    'field_name' => 'field_employer',
    'type' => 'computed',
    'module' => 'computed_field',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'value' => array(
        'type' => 'text',
        'length' => '256',
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
        'weight' => '13',
        'settings' => array(),
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'label' => 'Employer',
    'required' => 0,
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 0,
      'module' => 'computed_field',
      'settings' => array(),
      'type' => 'computed',
      'weight' => '49',
    ),
    'field_name' => 'field_employer',
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
