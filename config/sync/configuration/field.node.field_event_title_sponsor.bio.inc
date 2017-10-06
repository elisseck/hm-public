<?php
/**
 * @file
 * field.node.field_event_title_sponsor.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'translatable' => '1',
    'entity_types' => array(),
    'settings' => array(
      'uri_scheme' => 'public',
      'default_image' => 0,
      'profile2_private' => FALSE,
    ),
    'storage' => array(
      'type' => 'field_sql_storage',
      'settings' => array(),
      'module' => 'field_sql_storage',
      'active' => '1',
      'details' => array(
        'sql' => array(
          'FIELD_LOAD_CURRENT' => array(
            'field_data_field_event_title_sponsor' => array(
              'fid' => 'field_event_title_sponsor_fid',
              'alt' => 'field_event_title_sponsor_alt',
              'title' => 'field_event_title_sponsor_title',
              'width' => 'field_event_title_sponsor_width',
              'height' => 'field_event_title_sponsor_height',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_event_title_sponsor' => array(
              'fid' => 'field_event_title_sponsor_fid',
              'alt' => 'field_event_title_sponsor_alt',
              'title' => 'field_event_title_sponsor_title',
              'width' => 'field_event_title_sponsor_width',
              'height' => 'field_event_title_sponsor_height',
            ),
          ),
        ),
      ),
    ),
    'foreign keys' => array(
      'fid' => array(
        'table' => 'file_managed',
        'columns' => array(
          'fid' => 'fid',
        ),
      ),
    ),
    'indexes' => array(
      'fid' => array(
        0 => 'fid',
      ),
    ),
    'field_name' => 'field_event_title_sponsor',
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
    'label' => 'Main Sponsor',
    'widget' => array(
      'weight' => '54',
      'type' => 'image_image',
      'module' => 'image',
      'active' => 1,
      'settings' => array(
        'progress_indicator' => 'throbber',
        'preview_image_style' => 'thumbnail',
        'insert' => 0,
        'insert_styles' => array(
          'auto' => 'auto',
          'link' => 0,
          'image' => 0,
          'image_about_us' => 0,
          'image_bg_image_makerheading' => 0,
          'image_bio_landing' => 0,
          'image_bio_photo' => 0,
          'colorbox__about_us' => 0,
          'colorbox__bg_image_makerheading' => 0,
          'colorbox__bio_landing' => 0,
          'colorbox__bio_photo' => 0,
          'colorbox__digital_archive_block' => 0,
          'colorbox__education' => 0,
          'colorbox__event' => 0,
          'colorbox__events_programs' => 0,
          'colorbox__event_sponsor' => 0,
          'colorbox__featured_maker' => 0,
          'colorbox__gallery_images' => 0,
          'colorbox__hp_makers_categories' => 0,
          'colorbox__interchangeable_block' => 0,
          'colorbox__large' => 0,
          'colorbox__lightbox' => 0,
          'colorbox__lightbox_2' => 0,
          'colorbox__medium' => 0,
          'colorbox__my_history_chest' => 0,
          'colorbox__news' => 0,
          'colorbox__news-node' => 0,
          'colorbox__press' => 0,
          'colorbox__product' => 0,
          'colorbox__sponsor' => 0,
          'colorbox__store_item' => 0,
          'colorbox__sub-footer_nav_image' => 0,
          'colorbox__sub_footer_small' => 0,
          'colorbox__thumbnail' => 0,
          'colorbox__title_sponsor' => 0,
          'colorbox__uc_cart' => 0,
          'colorbox__uc_category' => 0,
          'colorbox__uc_product' => 0,
          'colorbox__uc_product_full' => 0,
          'colorbox__uc_product_list' => 0,
          'colorbox__uc_thumbnail' => 0,
          'image_digital_archive_block' => 0,
          'image_education' => 0,
          'image_event' => 0,
          'image_events_programs' => 0,
          'image_event_sponsor' => 0,
          'image_featured_maker' => 0,
          'image_gallery_images' => 0,
          'image_hp_makers_categories' => 0,
          'image_interchangeable_block' => 0,
          'image_large' => 0,
          'image_lightbox' => 0,
          'image_lightbox_2' => 0,
          'image_medium' => 0,
          'image_my_history_chest' => 0,
          'image_news' => 0,
          'image_news-node' => 0,
          'image_press' => 0,
          'image_product' => 0,
          'image_sponsor' => 0,
          'image_store_item' => 0,
          'image_sub-footer_nav_image' => 0,
          'image_sub_footer_small' => 0,
          'image_thumbnail' => 0,
          'image_title_sponsor' => 0,
          'image_uc_cart' => 0,
          'image_uc_category' => 0,
          'image_uc_product' => 0,
          'image_uc_product_full' => 0,
          'image_uc_product_list' => 0,
          'image_uc_thumbnail' => 0,
        ),
        'insert_default' => 'auto',
        'insert_class' => '',
        'insert_width' => '',
      ),
    ),
    'settings' => array(
      'file_directory' => '',
      'file_extensions' => 'png gif jpg jpeg',
      'max_filesize' => '',
      'max_resolution' => '',
      'min_resolution' => '',
      'alt_field' => 0,
      'title_field' => 0,
      'user_register_form' => FALSE,
      'default_image' => 0,
    ),
    'display' => array(
      'default' => array(
        'label' => 'above',
        'type' => 'hidden',
        'weight' => '57',
        'settings' => array(),
      ),
      'teaser' => array(
        'type' => 'hidden',
        'label' => 'above',
        'settings' => array(),
        'weight' => 0,
      ),
    ),
    'required' => 0,
    'description' => '',
    'field_name' => 'field_event_title_sponsor',
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
