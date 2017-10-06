<?php
/**
 * @file
 * field.node.field_age.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'entity_types' => array(),
    'foreign keys' => array(),
    'indexes' => array(),
    'settings' => array(
      'code' => 'if (is_null(trim($entity->field_birth_date[\'und\'][0][\'value\']))) {
$date = $entity->field_birth_date[\'und\'][0][\'value\'];
list($m,$d,$Y) = explode("/", $date);
$compare =  isset($entity->field_death_date[\'und\'][0][\'value\']) ?  strtotime($entity->field_death_date[\'und\'][0][\'value\']) : time();
$entity_field[0][\'value\'] = ( date("md", $compare) < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}',
      'display_format' => '$display_output = $entity_field_item[\'value\'];',
      'store' => 1,
      'database' => array(
        'data_type' => 'int',
        'data_length' => '32',
        'data_size' => 'normal',
        'data_precision' => '10',
        'data_scale' => '2',
        'data_default' => '',
        'data_not_NULL' => 0,
        'data_index' => 0,
      ),
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
            'field_data_field_age' => array(
              'value' => 'field_age_value',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_age' => array(
              'value' => 'field_age_value',
            ),
          ),
        ),
      ),
    ),
    'field_name' => 'field_age',
    'type' => 'computed',
    'module' => 'computed_field',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'value' => array(
        'type' => 'int',
        'size' => 'normal',
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
        'weight' => '43',
        'settings' => array(),
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => '0',
      ),
    ),
    'label' => 'Age',
    'required' => 0,
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'weight' => '30',
      'type' => 'computed',
      'module' => 'computed_field',
      'active' => 0,
      'settings' => array(),
    ),
    'field_name' => 'field_age',
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
