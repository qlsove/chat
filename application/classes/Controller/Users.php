<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Users extends Controller_Template_Default {

  public function action_index() {
    $data["users"]  = ORM::factory('Userlist')->getUsers(Auth::instance()->get_user()->id);
    $data["active"] = strtolower($this->request->controller());
    $data["error"]  ="The list is empty";

    $this->template->title   = 'Peoples';
    $this->template->title   = 'Peoples';
    $this->template->content = View::factory('users', $data);
  }

}
