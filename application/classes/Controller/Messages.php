<?php
class Controller_Messages extends Controller_Template_Page {

  public function action_inbox() {
    $id       = Auth::instance()->get_user()->id;
    $tempdata = ORM::factory('Message')->getInMsg($id);
    foreach ($tempdata as $tempitem)
      $data["messages"][] = array('id' => $tempitem->id, 'user' => $tempitem->sender->email, 'body' => $tempitem->body, 'timestamp' => $tempitem->timestamp, 'class' => $tempitem->status);
    $data["active"] = $this->request->action();
    $data["error"]  = "The list is empty";

    $this->template->title   = 'Inbox';
    $this->template->scripts = array('assets/js/messages.js');
    $this->template->content = View::factory('messages', $data);
  }


  public function action_sent() {
    $id       = Auth::instance()->get_user()->id;
    $tempdata = ORM::factory('Message')->getSentMsg($id);
    foreach ($tempdata as $tempitem)
      $data["messages"][] = array('id' => $tempitem->id, 'user' => $tempitem->receiver->email, 'body' => $tempitem->body, 'timestamp' => $tempitem->timestamp, 'class' => $tempitem->status);
    $data["active"] = $this->request->action();
    $data["error"]  = "The list is empty";
    
    $this->template->title   = 'Sent';
    $this->template->scripts = array('assets/js/messages.js');
    $this->template->content = View::factory('messages', $data);
  }


  public function action_dialog() {
    $id       = $this->request->param('id');
    $tempdata = ORM::factory('Message')->getDialog(Auth::instance()->get_user()->id, $id);
    foreach ($tempdata as $tempitem) {
      if ($tempitem["from"] == Auth::instance()->get_user()->id)
        $data["messages"][] = array('id' => $tempitem["id"], 'class' => 'sentmsg', 'body' => nl2br($tempitem["body"]), 'timestamp' => $tempitem["timestamp"]);
      if ($tempitem["to"] == Auth::instance()->get_user()->id)
        $data["messages"][] = array('id' => $tempitem["id"], 'class' => 'inmsg', 'body' => nl2br($tempitem["body"]), 'timestamp' => $tempitem["timestamp"]);
    }

    $data["active"] = 'dialogs';
    $data["user"]   = $id;
    $data["error"]  = "The list is empty";
    $this->template->title   = 'Dialog';
    $this->template->scripts = array('assets/js/scrollTo.min.js', 'assets/js/dialog.js');
    $this->template->content = View::factory('dialog', $data);
  }


  public function action_add() {
    Request::initial()->is_ajax() || die;
    $me       = Auth::instance()->get_user()->id;
    $text     = $this->request->post('text');
    $user     = $this->request->post('user');
    $id       = $this->request->post('id');
    ORM::factory('Message')->addMessage($me, $user, $text);
    ORM::factory('Message')->setRead($me, $user, $id);
    $tempdata = ORM::factory('Message')->updateDialog($me, $user, $id);
    foreach ($tempdata as $tempitem) {
      if($tempitem["from"] == $me)
        $data["messages"][] = array('id' => $tempitem["id"], 'class' => 'sentmsg', 'body' => $tempitem["body"], 'timestamp' => $tempitem["timestamp"]);
      if($tempitem["to"] == $me)
        $data["messages"][] = array('id' => $tempitem["id"], 'class' => 'inmsg', 'body' => $tempitem["body"], 'timestamp' => $tempitem["timestamp"]);
    }
    die(json_encode($data["messages"]));
  }


  public function action_update_inbox() {
    Request::initial()->is_ajax() || die;
    $id              = $this->request->post('id');
    $newcount["num"] = Site::update_inbox($id);
    die(json_encode($newcount));
  }


  public function action_update_dialog() {
    Request::initial()->is_ajax() || die;
    $me       = Auth::instance()->get_user()->id;
    $user     = $this->request->post('user');
    $id       = $this->request->post('id');
    $tempdata = ORM::factory('Message')->updateDialog($me, $user, $id);
      if (count($tempdata) > 0) {
        $data["messages"]["status"] ="ok";
        foreach ($tempdata as $tempitem) {
          if ($tempitem["from"] == $me)
            $data["messages"]["body"][] = array('id' => $tempitem["id"], 'class' => 'sentmsg', 'body' => $tempitem["body"], 'timestamp' => $tempitem["timestamp"]);
          if ($tempitem["to"] == $me)
            $data["messages"]["body"][] = array('id' => $tempitem["id"], 'class' => 'inmsg', 'body' => $tempitem["body"], 'timestamp' => $tempitem["timestamp"]);
        }
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

}
