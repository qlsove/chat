<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Out extends Controller {

	public function action_index() {
		Auth::instance()->logout();
    	$this->redirect(URL::site(NULL, TRUE).'in');
	}


} 
