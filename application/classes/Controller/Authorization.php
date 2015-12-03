<?php
class Controller_Authorization extends Controller_Template {

  public $template = 'layouts/default';

  public function before() {
    parent::before();
    if ($this->auto_render) {
      $this->template->title   = 'Auntefication';
      $this->template->styles  = array('assets/css/login/style.css', 'assets/css/login/animate-custom.css');
      $this->template->scripts = array('assets/js/jquery.js','assets/js/validate.js');
      $this->template->header  = '';
    }
  }


  public function action_main() {
    if (Auth::instance()->logged_in()) {
      $this->redirect(URL::site(NULL, TRUE).'inbox');
    }
    if (null !==$this->request->post('loginbtn')) {
      $login       = $this->request->post('username');
      $password    = $this->request->post('password');
      $remember_me = (null !==$this->request->post('loginkeeping')) ? TRUE : FALSE;
      if(Auth::instance()->login($login, $password, $remember_me))
        $this->redirect(URL::site(NULL, TRUE).'inbox');
    }
    $this->template->content = View::factory('login');
  }


  public function action_login() {
    Request::initial()->is_ajax() || die;
    $login    = $this->request->post('username');
    $password = $this->request->post('password');
    $remember = ($this->request->post('remember') == 'true') ? TRUE : FALSE;
    if (Auth::instance()->login($login, $password, $remember)) {
      $message['status'] = 'ok';
      $message['url']    = URL::site(NULL, TRUE); 
      die(json_encode($message));
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
      die(json_encode($message));
    }
  }


  public function action_logout() {
    Auth::instance()->logout();
    $this->redirect(URL::site(NULL, TRUE));
  }


  public function action_registration(){
    Request::initial()->is_ajax() || die;
    $emailsignup    = ORM::factory('User')->checkUser('email', $this->request->post('emailsignup'));
    $usernamesignup = ORM::factory('User')->checkUser('username', $this->request->post('usernamesignup'));
    if ($emailsignup->loaded() || $usernamesignup->loaded()) {
      if ($emailsignup->loaded()) {
        $message[0]['text']   = "User with this email is already exist!";
        $message[0]['item']   = "emailsignup"; 
        $message[0]['status'] = 'error';
      }
      if ($usernamesignup->loaded()) {
        $message[1]['text']   = "User with username email is already exist!"; 
        $message[1]['item']   = "usernamesignup"; 
        $message[1]['status'] = 'error';
      }
      die(json_encode($message));
    }

    $token = md5(time().$this->request->post('usernamesignup').$this->request->post('emailsignup'));
    $data  = array(
      'username'         => $this->request->post('usernamesignup'),
      'email'            => $this->request->post('emailsignup'),
      'password'         => $this->request->post('passwordsignup'),
      'password_confirm' => $this->request->post('passwordsignup_confirm'),
      'token'            => $token,
    );
    
    $user    = ORM::factory('User')->create_user($data, array('username','email','password','token'));
    $url     = URL::site(NULL, TRUE).'approved?token='.$token;
    $config  = Kohana::$config->load('email');
    $to      = $this->request->post('emailsignup');
    $subject = 'Підтвердження реєстрації на сайті';
    $from    = $config['email'];
    $text    = 'Ви були зареєстровані на нашому сайті. Для підтвердження реєстрації перейдіть по посиланню: '.$url;
    Email::connect($config['main']);
    Email::send($to, $from, $subject, $text, $html = false);

    $message[0]['text']   = "Link to activate your account sent for your email";
    $message[0]['item']   = "emailsignup"; 
    $message[0]['status'] = 'ok';
    die(json_encode($message));
  }


  public function action_approved() {
    $token = $this->request->query('token');
    $user  = ORM::factory('User')->checkToken($token); 
    if ($user->loaded()) {
      $user->add('roles',ORM::factory('Role', array('name'=>'login')));
      $user->update_user(array('token'=>null), array('token'));
      Auth::instance()->logout();
      Auth::instance()->force_login($user->get('username'));
      $this->redirect(URL::site(NULL, TRUE).'inbox');
    }
    else
      $this->redirect(URL::site(NULL, TRUE));
  }

}
