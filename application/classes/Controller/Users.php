<?php
class Controller_Users extends Controller_Template_Page {

  public function action_list() {
    $data["users"]  = ORM::factory('User')->getUsers(Auth::instance()->get_user()->id);
    $data["active"] = strtolower($this->request->controller());
    $data["error"]  = "The list is empty";

    $this->template->title   = 'Peoples';
    $this->template->content = View::factory('users', $data);
  }

}
