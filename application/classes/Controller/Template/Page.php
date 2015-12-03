<?php
class Controller_Template_Page extends Controller_Template {

	public $template = 'layouts/default';

  public function before() {
    parent::before();
    if ($this->auto_render) {
      $this->template->title   = '';
      $this->template->styles  = array();
      $this->template->scripts = array();
      $this->template->header  = View::factory('header');
      $this->template->content = '';
    }
    if (!Auth::instance()->logged_in())
      $this->redirect(URL::site(NULL, TRUE).'in');
  }


  public function after() {
    if ($this->auto_render) {
      $styles  = array('assets/css/bootstrap.min.css', 'assets/css/style.css');
      $scripts = array('assets/js/jquery.js');
      $this->template->styles  = array_merge($styles, $this->template->styles);
      $this->template->scripts = array_merge($scripts, $this->template->scripts);
    }
    parent::after();
  }

}
