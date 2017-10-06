<?php
/**
 * @file
 * field.node.field_bio_pdf.bio.inc
 */

$api = '2.0.0';

$data = array(
  'field_config' => array(
    'translatable' => '0',
    'entity_types' => array(),
    'settings' => array(
      'display_field' => 0,
      'display_default' => 0,
      'uri_scheme' => 'public',
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
            'field_data_field_bio_pdf' => array(
              'fid' => 'field_bio_pdf_fid',
              'display' => 'field_bio_pdf_display',
              'description' => 'field_bio_pdf_description',
            ),
          ),
          'FIELD_LOAD_REVISION' => array(
            'field_revision_field_bio_pdf' => array(
              'fid' => 'field_bio_pdf_fid',
              'display' => 'field_bio_pdf_display',
              'description' => 'field_bio_pdf_description',
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
    'field_name' => 'field_bio_pdf',
    'type' => 'file',
    'module' => 'file',
    'active' => '1',
    'locked' => '0',
    'cardinality' => '2',
    'deleted' => '0',
    'columns' => array(
      'fid' => array(
        'description' => 'The {file_managed}.fid being referenced in this field.',
        'type' => 'int',
        'not null' => FALSE,
        'unsigned' => TRUE,
      ),
      'display' => array(
        'description' => 'Flag to control whether this file should be displayed when viewing content.',
        'type' => 'int',
        'size' => 'tiny',
        'unsigned' => TRUE,
        'not null' => TRUE,
        'default' => 1,
      ),
      'description' => array(
        'description' => 'A description of the file.',
        'type' => 'text',
        'not null' => FALSE,
      ),
    ),
  ),
  'field_instance' => array(
    'label' => 'Interview Description',
    'widget' => array(
      'weight' => '53',
      'type' => 'file_generic',
      'module' => 'file',
      'active' => 1,
      'settings' => array(
        'progress_indicator' => 'throbber',
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
          'colorbox__homepage_become_member_block' => 0,
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
          'image_homepage_become_member_block' => 0,
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
      'file_extensions' => 'txt pdf rtf doc',
      'max_filesize' => '20 MB',
      'description_field' => 0,
      'user_register_form' => FALSE,
    ),
    'display' => array(
      'default' => array(
        'label' => 'above',
        'type' => 'hidden',
        'weight' => '60',
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
    'field_name' => 'field_bio_pdf',
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
  1 => 'file',
);
