<?php 
return array(
  'login' =>  array(
    'URI'      => 'login',
    'defaults' => array('controller' => 'authorization', 'action' => 'login',),
  ),

  'out' =>  array(
    'URI'      => 'out',
    'defaults' => array('controller' => 'authorization', 'action' => 'logout',),
  ),

  'registration' =>  array(
    'URI'      => 'registration',
    'defaults' => array('controller' => 'authorization', 'action' => 'registration',),
  ),

  'approved' =>  array(
    'URI'      => 'approved',
    'defaults' => array('controller' => 'authorization', 'action' => 'approved',),
  ),

  'dialogs' =>  array(
    'URI'      => 'dialogs',
    'defaults' => array('controller' => 'messages', 'action' => 'dialogs',),
  ),

  'type' =>  array(
    'URI'      => '<type>',
    'defaults' => array('controller' => 'messages', 'action' => 'type',),
    'regexp'   => array('type' => 'inbox|sent'),
  ),

  'dialog' =>  array(
    'URI'      => '<dialog>/<id>',
    'defaults' => array('controller' => 'messages', 'action' => 'dialog',),
    'regexp'   => array('id' => '(\d+)'),
  ),

  'add' =>  array(
    'URI'      => 'add',
    'defaults' => array('controller' => 'messages', 'action' => 'add',),
  ),

  'update_inbox' =>  array(
    'URI'      => 'update_inbox',
    'defaults' => array('controller' => 'messages', 'action' => 'update_inbox',),
  ),

  'update_dialog' =>  array(
    'URI'      => 'update_dialog',
    'defaults' => array('controller' => 'messages', 'action' => 'update_dialog',),
  ),

  'set_read_once' =>  array(
    'URI'      => 'set_read_once',
    'defaults' => array('controller' => 'messages', 'action' => 'set_read_once',),
  ),

  'set_delete' =>  array(
    'URI'      => 'set_delete',
    'defaults' => array('controller' => 'messages', 'action' => 'set_delete',),
  ),

  'default' =>  array(
    'URI'      => '(<controller>(/<action>(/<id>)))',
    'defaults' => array('controller' => 'authorization', 'action' => 'main',),
  )
);
