<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Msg extends Controller_Template_Default {

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


  public function action_add() {
      if (Request::initial()->is_ajax()) {
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
        echo json_encode($data["messages"]);
        exit();
      }
  }


  public function action_updateInbox() {
      if (Request::initial()->is_ajax()) {
        $id              = $this->request->post('id');
        $newcount["num"] = Inbox::count($id);
        echo json_encode($newcount);
        exit();
      }
  }


  public function action_updateDialog() {
      if (Request::initial()->is_ajax()) {
        $me       = Auth::instance()->get_user()->id;
        $user     = $this->request->post('user');
        $id       = $this->request->post('id');
        $tempdata = ORM::factory('Message')->updateDialog($me, $user, $id);
          if (count($tempdata)>0) {
            $data["messages"]["status"] ="ok";
              foreach ($tempdata as $tempitem) {
                if ($tempitem["from"] == $me)
                  $data["messages"]["body"][] = array('id' => $tempitem["id"], 'class' => 'sentmsg', 'body' => $tempitem["body"], 'timestamp' => $tempitem["timestamp"]);
                if ($tempitem["to"] == $me)
                  $data["messages"]["body"][] = array('id' => $tempitem["id"], 'class' => 'inmsg', 'body' => $tempitem["body"], 'timestamp' => $tempitem["timestamp"]);
              }
            echo json_encode($data["messages"]);
          }
          else {
            $data["status"] ="Empty";
            echo json_encode($data);
          }
        exit();
      }
  }


  public function action_setReadOnce() {
      if (Request::initial()->is_ajax()) {
        $id = $this->request->post('id');
        ORM::factory('Message')->setReadOnce($id);
      }
  }


  public function action_setDeleteMsg() {
      if (Request::initial()->is_ajax()) {
        $id     = $this->request->post('id');
        $status = $this->request->post('status');
        ORM::factory('Message')->setDelOnce($id, $status);
      }
  }

}
