<?php
class Model_User extends Model_Auth_User {

  public function getUsers($id) { 
    $query = ORM::factory('User')
      ->where('id', '!=',  $id)
      ->find_all()
      ->as_array();
      return $query;
  }
}