<?php defined('SYSPATH') or die('No direct script access.');

class Inbox extends Controller {

  public static function count($per)
  {
    $count='';
      if(Auth::instance()->logged_in())
      {
        $result = ORM::factory('Message')->getNew(Auth::instance()->get_user()->id);
          if(count($result)>0)
        $count=' ('.count($result).')';
      }
    return $count;
  }

} 