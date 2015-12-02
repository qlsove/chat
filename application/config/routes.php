<?php 
    $config['login'] = array(
        'URI'      => 'login',
        'defaults' => array('controller' => 'authorization', 'action' => 'login',),
    );

    $config['out'] = array(
        'URI'      => 'out',
        'defaults' => array('controller' => 'authorization', 'action' => 'logout',),
    );

    $config['registration'] = array(
        'URI'      => 'registration',
        'defaults' => array('controller' => 'authorization', 'action' => 'registration',),
    );

    $config['approved'] = array(
        'URI'      => 'approved',
        'defaults' => array('controller' => 'authorization', 'action' => 'approved',),
    );

    $config['users'] = array(
        'URI'      => 'users',
        'defaults' => array('controller' => 'users', 'action' => 'list',),
    );

    $config['inbox'] = array(
        'URI'      => 'inbox',
        'defaults' => array('controller' => 'messages', 'action' => 'inbox',),
    );

    $config['sent'] = array(
        'URI'      => 'sent',
        'defaults' => array('controller' => 'messages', 'action' => 'sent',),
    );

    $config['dialog'] = array(
        'URI'      => '<dialog>/<id>',
        'defaults' => array('controller' => 'messages', 'action' => 'dialog',),
        'regexp'   => array('id' => '.+'),
    );

    $config['add'] = array(
        'URI'      => 'add',
        'defaults' => array('controller' => 'messages', 'action' => 'add',),
    );

    $config['update_inbox'] = array(
        'URI'      => 'update_inbox',
        'defaults' => array('controller' => 'messages', 'action' => 'update_inbox',),
    );

    $config['update_dialog'] = array(
        'URI'      => 'update_dialog',
        'defaults' => array('controller' => 'messages', 'action' => 'update_dialog',),
    );

    $config['set_read_once'] = array(
        'URI'      => 'set_read_once',
        'defaults' => array('controller' => 'messages', 'action' => 'set_read_once',),
    );

    $config['set_delete'] = array(
        'URI'      => 'set_delete',
        'defaults' => array('controller' => 'messages', 'action' => 'set_delete',),
    );

    $config['default'] = array(
        'URI'      => '(<controller>(/<action>(/<id>)))',
        'defaults' => array('controller' => 'authorization', 'action' => 'main',),
    );

    return $config;
