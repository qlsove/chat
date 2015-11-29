<?php

$application = 'application';
$modules = 'modules';
$system = 'system';
define('EXT', '.php');
ini_set('xdebug.var_display_max_depth', 10);

error_reporting(E_ALL & ~E_DEPRECATED );
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

	if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
		$application = DOCROOT.$application;

	if ( ! is_dir($modules) AND is_dir(DOCROOT.$modules))
		$modules = DOCROOT.$modules;

	if ( ! is_dir($system) AND is_dir(DOCROOT.$system))
		$system = DOCROOT.$system;

define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);
define('MODPATH', realpath($modules).DIRECTORY_SEPARATOR);
define('SYSPATH', realpath($system).DIRECTORY_SEPARATOR);


unset($application, $modules, $system);

	if (file_exists('install'.EXT))
	{
		return include 'install'.EXT;
	}

	if ( ! defined('KOHANA_START_TIME'))
	{
		define('KOHANA_START_TIME', microtime(TRUE));
	}


	if ( ! defined('KOHANA_START_MEMORY'))
	{
		define('KOHANA_START_MEMORY', memory_get_usage());
	}


require APPPATH.'bootstrap'.EXT;

	if (PHP_SAPI == 'cli')
	{
		class_exists('Minion_Task') OR die('Please enable the Minion module for CLI support.');
		set_exception_handler(array('Minion_Exception', 'handler'));

		Minion_Task::factory(Minion_CLI::options())->execute();
	}
	else
	{
		echo Request::factory(TRUE, array(), FALSE)
			->execute()
			->send_headers(TRUE)
			->body();
	}
