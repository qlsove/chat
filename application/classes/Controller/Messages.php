<?php
class Controller_Messages extends Controller_Template_Page {

  public function action_type() {
    $type        = $this->request->param('type');
    $id          = Auth::instance()->get_user()->id;
    $state       = $type == "sent" ? "from" : "to";
    $not_removed = $type == "sent" ? "removeBySender" : "removeByReceiver";
    $sender      = $type == "inbox";
    $tempdata    = ORM::factory('Message')->getMsg($state, $not_removed, $id);
    $status      = array_fill(0, count($tempdata), $sender);
    $data["messages"] = array_map(array($this, 'msg_type'), $tempdata, $status);
    $data["active"]   = $type;
    $data["error"]    = "The ".$type." list is empty";

    $this->template->title   = ucfirst($type);
    $this->template->scripts = array('assets/js/messages.js');
    $this->template->content = View::factory('messages', $data);
  }


  public function action_dialog() {
    $id = $this->request->param('id');
    $me = Auth::instance()->get_user()->id;
    $data["partner"]  = ORM::factory('User', $id)->email;
    $data["messages"] = $this->update("getDialog", $me, $id)["value"];
    $data["active"]   = 'dialogs';
    $data["user"]     = $id;
    $data["error"]    = "The list is empty";

    $this->template->title   = 'Dialog';
    $this->template->scripts = array('assets/js/scrollTo.min.js', 'assets/js/dialog.js');
    $this->template->content = View::factory('dialog', $data);
  }


  public function action_dialogs() {
    $data["users"]  = ORM::factory('User')->getUsers(Auth::instance()->get_user()->id);
    $data["active"] = "dialogs";
    $data["error"]  = "The list is empty";

    $this->template->title   = 'Dialogs';
    $this->template->content = View::factory('dialogs', $data);
  }


  public function action_add() {
    Request::initial()->is_ajax() || die;
    $me   = Auth::instance()->get_user()->id;
    $text = $this->request->post('text');
    $user = $this->request->post('user');
    $id   = $this->request->post('id');
    ORM::factory('Message')->addMessage($me, $user, $text);
    ORM::factory('Message')->setRead($me, $user, $id);
    $data["messages"] = $this->update("updateDialog", $me, $id, $user)["value"];
    die(json_encode($data["messages"]));
  }


  public function action_update_inbox() {
    Request::initial()->is_ajax() || die;
    $id     = Auth::instance()->get_user()->id;
    $result = ORM::factory('Message')->getNew($id);
    $newcount["num"] = ($result->count() > 0) ? count($result) : 0;
    die(json_encode($newcount));
  }


  public function action_update_dialog() {
    Request::initial()->is_ajax() || die;
    $me   = Auth::instance()->get_user()->id;
    $user = $this->request->post('user');
    $id   = $this->request->post('id');
    if ($this->update("updateDialog", $me, $id, $user)["count"] > 0) {
      $data["messages"]["status"] = "ok";
      $data["messages"]["body"][] = $this->update("updateDialog", $me, $id, $user)["value"];
      die(json_encode($data["messages"]));
    }
    else {
      $data["status"] ="Empty";
      die(json_encode($data));
    }
  }


  public function action_set_read_once() {
    Request::initial()->is_ajax() || die;
    $id = $this->request->post('id');
    ORM::factory('Message')->setReadOnce($id);
  }


  public function action_set_delete() {
    Request::initial()->is_ajax() || die;
    $id     = $this->request->post('id');
    $status = $this->request->post('status');
    ORM::factory('Message')->setDelOnce($id, $status);
  }


  public function update($func, $me, $id, $user = 0) {
    $tempdata = ($func == "updateDialog") ? ORM::factory('Message')->updateDialog($me, $user, $id) : ORM::factory('Message')->getDialog($me, $id);
    $convert  = array_fill(0, count($tempdata), true);
    $sender   = array_fill(0, count($tempdata), $me);
    $data["count"] = count($tempdata);
    $data["value"] = array_map(array($this, 'msg_new'), $tempdata, $sender, $convert);
    return $data;
  }


  public function msg_type($tempitem, $sender) {
    return array(
      'id'      => $tempitem->id,
      'user'    => $tempitem->{$sender ? "sender" : "receiver"}->email,
      'body'    => $tempitem->body,
      'created' => $tempitem->created,
      'class'   => $tempitem->status
    );
  }


  public function msg_new($tempitem, $me, $convert) {
    return array(
      'id'      => $tempitem["id"],
      'class'   => ($tempitem["from"] == $me) ? "sentmsg" : "inmsg",
      'body'    => (!$convert) ? $tempitem["body"] : nl2br($tempitem["body"]),
      'created' => $tempitem["created"]
    );
  }

}