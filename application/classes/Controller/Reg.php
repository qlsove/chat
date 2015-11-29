<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Reg extends Controller {

  public function action_index()
  {
      if (Request::initial()->is_ajax()) {
        $emailsignup    = ORM::factory('User')->where('email', '=', $this->request->post('emailsignup'))->find()->as_array();
        $usernamesignup = ORM::factory('User')->where('username', '=', $this->request->post('usernamesignup'))->find()->as_array();
          if (!empty($emailsignup["email"]) || !empty($usernamesignup["username"])) {
              if (!empty($emailsignup["email"])) {
                $message[0]['text']   = "User with this email is already exist!";
                $message[0]['item']   = "emailsignup"; 
                $message[0]['status'] = 'error';
              }
              if (!empty($usernamesignup["username"])) {
                $message[1]['text']   = "User with username email is already exist!"; 
                $message[1]['item']   = "usernamesignup"; 
                $message[1]['status'] = 'error';
              }
            echo json_encode($message);
          }
          else
          {
            if ($post = $this->request->post()) {
              $token = md5(time().$this->request->post('usernamesignup').$this->request->post('emailsignup'));
              $data = array(
                'username'         => $this->request->post('usernamesignup'),
                'email'            => $this->request->post('emailsignup'),
                'password'         => $this->request->post('passwordsignup'),
                'password_confirm' => $this->request->post('passwordsignup_confirm'),
                'token'            => $token,
              );

              $user    = ORM::factory('User')->create_user($data, array('username','email','password','token'));
              $url     = URL::site(NULL, TRUE).'reg/approved?token='.$token;
              $config  = Kohana::$config->load('email');
              $to      = $this->request->post('emailsignup');
              $subject = 'Підтвердження реєстрації на сайті';
              $from    = 'noreply@chatter.pe.hu';
              $text    = 'Ви були зареєстровані на нашому сайті. Для підтвердження реєстрації перейдіть по посиланню: '.$url;
              Email::connect($config);
              Email::send($to, $from, $subject, $text, $html = false);

              $message[0]['text']   = "Link to activate your account sent for your email";
              $message[0]['item']   = "emailsignup"; 
              $message[0]['status'] = 'ok';
              echo json_encode($message);
            }
          }
      }
  }


  public function action_approved() {
    $token = $this->request->query('token');
      if ($token) {
        $user = ORM::factory('User')->where('token', '=', $token)->find();
          if ($user->get('id')) {
            $user->add('roles',ORM::factory('Role',array('name'=>'login')));
            $user->update_user(array('token'=>null), array('token'));
            Auth::instance()->force_login($user->get('username'));
            $this->redirect(URL::site(NULL, TRUE).'msg/inbox');
          }
      }
      else
        $this->redirect(URL::site(NULL, TRUE).'in#tologin');
  }

}