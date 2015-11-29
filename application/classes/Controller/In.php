<?php defined('SYSPATH') or die('No direct script access.');

class Controller_In extends Controller_Template {

  public $template = 'templates/default';

  public function action_index() {
      if (Auth::instance()->logged_in()) {
        $this->redirect(URL::site(NULL, TRUE).'msg/inbox/'.Auth::instance()->get_user()->id);
      }
      if (null !==$this->request->post('loginbtn')) {
        $login       = $this->request->post('username');
        $password    = $this->request->post('password');
        $remember_me = (null !==$this->request->post('loginkeeping')) ? TRUE : FALSE;
          if(Auth::instance()->login($login, $password, $remember_me))
              $this->redirect(URL::site(NULL, TRUE).'msg/inbox/'.Auth::instance()->get_user()->id);
      }

    $this->template->title   = 'Auntefication';
    $this->template->styles  = array('assets/css/login/style.css', 'assets/css/login/animate-custom.css' );
    $this->template->scripts = array('assets/js/jquery.js','assets/js/validate.js');
    $this->template->header  = '';
    $this->template->content = View::factory('login');
  }


  public function action_login() {
    if (Request::initial()->is_ajax()) {
        $login    = $this->request->post('username');
        $password = $this->request->post('password');
        $remember = ($this->request->post('remember')=='true') ? TRUE : FALSE;
          if (Auth::instance()->login($login, $password, $remember)) {
            $message['status'] = 'ok';
            $message['url']    = URL::site(NULL, TRUE); 
            echo json_encode($message);
            exit();
          }
          else {
            $login = ORM::factory('User')->where('email', '=', $this->request->post('username'))->or_where('username', '=', $this->request->post('username'))->find()->as_array();
              if (!empty($login["id"])) {
                $message['text']   = "Incorrect password";
                $message['item']   = "password"; 
              }
              else {
                $message['text']   = "User not exist";
                $message['item']   = "username"; 
              }
            $message['status'] = 'error';
            echo json_encode($message);
            exit();
          }
      }
  }
}
