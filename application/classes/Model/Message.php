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


  public function getInMsg($id) {
    $query = DB::select()
      ->from($this->_table_name)
      ->where('to', '=', $id)
      ->and_where('removeByReceiver', '!=',  TRUE)
      ->as_object('Model_Message')
      ->execute();
      return $query;
  }


  public function getSentMsg($id) {
    $query = DB::select()
      ->from($this->_table_name)
      ->where('from', '=',  $id)
      ->and_where('removeBySender', '!=',  TRUE)
      ->as_object('Model_Message')
      ->execute();
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
    $query = DB::insert($this->_table_name, array('from', 'to', 'body'))
      ->values(array($me, $user, $text))
      ->execute();
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
    $query = DB::select()
        ->from($this->_table_name)
        ->where('to', '=',  $me)
        ->and_where('status', '=',  'unread')
        ->and_where('removeByReceiver', '!=',  TRUE)
        ->execute()
        ->as_array();
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
