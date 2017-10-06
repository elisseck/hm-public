<?php
/**
 * @file
 * vocabulary.birth_place.inc
 */

$api = '2.0.0';

$data = (object) array(
  'vid' => '5',
  'name' => 'Birth Place',
  'machine_name' => 'birth_place',
  'description' => 'Maker place of bith',
  'hierarchy' => '1',
  'module' => 'taxonomy',
  'weight' => '0',
  'rdf_mapping' => array(
    'rdftype' => array(
      0 => 'skos:ConceptScheme',
    ),
    'name' => array(
      'predicates' => array(
        0 => 'dc:title',
      ),
    ),
    'description' => array(
      'predicates' => array(
        0 => 'rdfs:comment',
      ),
    ),
  ),
);

$dependencies = array();

$optional = array();

$modules = array(
  0 => 'taxonomy',
);
