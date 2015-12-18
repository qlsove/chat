<?php
class Model_Message extends ORM {

  protected $_table_name = 'messages';

  protected $_belongs_to= array(
  'sender'  => array(
    'model'       => 'user',
    'foreign_key' => 'from',
    ),
  'receiver'  => array(
    'model'       => 'user',
    'foreign_key' => 'to',
    ),
  );

  public function getMsg($type, $not_removed, $id) {
    $query = ORM::factory('Message')
      ->where($type, '=', $id)
      ->and_where($not_removed, '!=',  TRUE)
      ->find_all()
      ->as_array();
    return $query;
  }


  public function getDialog($me, $user) {
    $query = DB::select()
      ->from($this->_table_name)
      ->or_where_open()
        ->where('from', '=',  $me)
        ->and_where('to', '=',  $user)
        ->and_where('removeBySender', '!=',  TRUE)
      ->or_where_close()
      ->or_where_open()
        ->where('to', '=',  $me)
        ->and_where('from', '=',  $user)
        ->and_where('removeByReceiver', '!=',  TRUE)
      ->or_where_close()
      ->order_by('id', 'ASC')
      ->execute()
      ->as_array();
    return $query;
  }


  public function addMessage($me, $user, $text) {
    $query = ORM::factory('Message')
      ->values(array('from' => $me, 'to' => $user, 'body' => $text))
      ->save();
  }


  public function updateDialog($me, $user, $id) {
    $query = DB::select()
      ->from($this->_table_name)
      ->or_where_open()
        ->where('from', '=',  $me)
        ->and_where('to', '=',  $user)
        ->and_where('id', '>',  $id)
        ->and_where('removeBySender', '!=',  TRUE)
      ->or_where_close()
      ->or_where_open()
        ->where('to', '=',  $me)
        ->and_where('from', '=',  $user)
        ->and_where('id', '>',  $id)
        ->and_where('removeByReceiver', '!=',  TRUE)
      ->or_where_close()
      ->order_by('id', 'ASC')
      ->execute()
      ->as_array();
    return $query;
  }


  public function getNew($me) {
    $query = ORM::factory('Message')
      ->where('to', '=',  $me)
      ->and_where('status', '=',  'unread')
      ->and_where('removeByReceiver', '!=',  TRUE)
      ->find_all();
    return $query;
  }


  public function setRead($me, $user, $id) {
    $query = DB::update($this->_table_name)
      ->set(array('status' => 'read'))
      ->where('to', '=', $me)
      ->and_where('from', '=',  $user)
      ->and_where('id', '<=',  $id)
      ->and_where('status', '=',  'unread')
      ->execute();
  }


  public function setReadOnce($id) {
    $query = DB::update($this->_table_name)
      ->set(array('status' => 'read'))
      ->where('id', '=',  $id)
      ->execute();
  }


  public function setDelOnce($id, $status) {
    $query = DB::update($this->_table_name)
      ->set(array($status => TRUE))
      ->where('id', '=',  $id)
      ->execute();
  }

}