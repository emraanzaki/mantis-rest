<?php
require_once 'config.php';
require_once 'misc_functions.php';
$config = get_config();
require_once $config['mantis']['root'] . '/core.php';

function __autoload($class)
{
	$class = strtolower($class);

	foreach (array("resources", "http") as $d) {
		if (file_exists("$d/$class.abstract.php")) {
			require_once("$d/$class.abstract.php");
			return;
		} elseif (file_exists("$d/$class.class.php")) {
			require_once("$d/$class.class.php");
			return;
		}
	}
}

function handle_error($errno, $errstr)
{
	throw new HTTPException(500, "Mantis encountered an error: " . error_string($errstr));
	$resp->send();
	exit;
}
set_error_handler("handle_error", E_USER_ERROR);
