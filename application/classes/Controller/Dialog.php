<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dialog extends Controller_Template_Default {

	public function action_user() {
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

}
