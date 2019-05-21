<?php
/**
 * Created by PhpStorm.
 * User: t2
 * Date: 8/30/18
 * Time: 10:28 AM
 */

namespace Drupal\thm_migrate_remix\Plugin\migrate\source;

use Drupal\user\Plugin\migrate\source\d7\User;
//use Drupal\migrate\Plugin\migrate\source\SqlBase;
//use Drupal\migrate\Row;


/**
 * Class User
 *
 * @MigrateSource(
 *   id = "d7_thm_user",
 *   source_module = "thm_migrate_remix",
 * )
 */
class D7User extends User {

}
/*class User extends SqlBase {

  protected $fields = [
    'uid', 'name', 'pass', 'mail', 'created', 'access', 'login', 'status',
    'uuid', 'init', 'data', 'picture', 'timezone', 'theme', 'signature',
    'signature_format', 'language'
  ];

  public function query() {
    return $this->select('users', 'u')
      ->fields('u', $this->fields)
      ->orderBy('uid', 'ASC');
  }

  public function fields() {
    $f = [];

    foreach ($this->fields as $field) {
      $f[$field] = $this->t($field);
    }

    return $f;
  }

  public function getIds() {
    return [ 'uid' => [ 'type' => 'integer' ] ];
  }

  public function prepareRow(Row $row) {
    return parent::prepareRow($row);
  }
}*/