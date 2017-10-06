<?php
/**
 * @file
 * field.node.field_archival_image2.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'entity_types' => array(),
    'foreign keys' => array(
      'fid' => array(
        'columns' => array(
          'fid' => 'fid',
        ),
        'table' => 'file_managed',
      ),
    ),
    'indexes' => array(
      'fid' => array(
        0 => 'fid',
      ),
    ),
    'settings' => array(
      'default_image' => 0,
      'uri_scheme' => 'public',
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
            'field_data_field_archival_image2' => array(
              'fid' => 'field_archival_image2_fid',
              'alt' => 'field_archival_image2_alt',
              'title' => 'field_archival_image2_title',
              'width' => 'field_archival_image2_width',
              'height' => 'field_archival_image2_height',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_archival_image2' => array(
              'fid' => 'field_archival_image2_fid',
              'alt' => 'field_archival_image2_alt',
              'title' => 'field_archival_image2_title',
              'width' => 'field_archival_image2_width',
              'height' => 'field_archival_image2_height',
            ),
          ),
        ),
      ),
    ),
    'field_name' => 'field_archival_image2',
    'type' => 'image',
    'module' => 'image',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '1',
    'deleted' => '0',
    'columns' => array(
      'fid' => array(
        'description' => 'The {file_managed}.fid being referenced in this field.',
        'type' => 'int',
        'not null' => FALSE,
        'unsigned' => TRUE,
      ),
      'alt' => array(
        'description' => 'Alternative image text, for the image\'s \'alt\' attribute.',
        'type' => 'varchar',
        'length' => 512,
        'not null' => FALSE,
      ),
      'title' => array(
        'description' => 'Image title text, for the image\'s \'title\' attribute.',
        'type' => 'varchar',
        'length' => 1024,
        'not null' => FALSE,
      ),
      'width' => array(
        'description' => 'The width of the image in pixels.',
        'type' => 'int',
        'unsigned' => TRUE,
      ),
      'height' => array(
        'description' => 'The height of the image in pixels.',
        'type' => 'int',
        'unsigned' => TRUE,
      ),
    ),
  ),
  'field_instance' => array(
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'hidden',
        'type' => 'hidden',
        'weight' => '16',
        'settings' => array(),
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => '0',
      ),
    ),
    'label' => 'Archival Photo 2',
    'required' => 0,
    'settings' => array(
      'alt_field' => 0,
      'file_directory' => 'photos/archival',
      'file_extensions' => 'png gif jpg jpeg',
      'max_filesize' => '',
      'max_resolution' => '',
      'min_resolution' => '',
      'title_field' => 0,
      'user_register_form' => FALSE,
      'default_image' => 0,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'image',
      'settings' => array(
        'preview_image_style' => 'thumbnail',
        'progress_indicator' => 'throbber',
        'insert' => 0,
        'insert_styles' => array(
          0 => 'auto',
        ),
        'insert_default' => array(
          0 => 'auto',
        ),
        'insert_class' => '',
        'insert_width' => '',
      ),
      'type' => 'image_image',
      'weight' => '18',
    ),
    'field_name' => 'field_archival_image2',
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
  1 => 'image',
);
