<?php defined('SYSPATH') or die('No direct script access.');
require SYSPATH.'classes/Kohana/Core'.EXT;
if (is_file(APPPATH.'classes/Kohana'.EXT))
	require APPPATH.'classes/Kohana'.EXT;
else
	require SYSPATH.'classes/Kohana'.EXT;

date_default_timezone_set('Europe/Kiev');
setlocale(LC_ALL, 'en_US.utf-8');
spl_autoload_register(array('Kohana', 'auto_load'));
ini_set('unserialize_callback_func', 'spl_autoload_call');
mb_substitute_character('none');
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];

if (isset($_SERVER['KOHANA_ENV']))
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));

Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
));

Kohana::$log->attach(new Log_File(APPPATH.'logs'));
Kohana::$config->attach(new Config_File);
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	'email'      => MODPATH.'email',			// E-mail
	'database'   => MODPATH.'database',   // Database access
));

Cookie::$salt = 'cghjklnkbvfcfhg34edfdty3edtfchd56';
Site::set_routes('routes');