<?php
return array(
  'default' => array(
    'type'       => 'MySQLi',
    'connection' => array(
      'hostname'   => 'localhost',
      'database'   => 'chat',
      'username'   => 'root',
      'password'   => '123qwASD',
      'persistent' => FALSE,
    ),
    'table_prefix' => '',
    'charset'      => 'utf8',
    'caching'      => FALSE,
  ),

  'alternate' => array(
    'type'       => 'PDO',
    'connection' => array(
      'dsn'        => 'mysql:host=localhost;dbname=database',
      'username'   => 'root',
      'password'   => '',
      'persistent' => FALSE,
    ),
    'table_prefix' => '',
    'charset'      => 'utf8',
    'caching'      => FALSE,
  ),
);