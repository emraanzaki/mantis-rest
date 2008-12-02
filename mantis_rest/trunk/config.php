<?php
$config = parse_ini_file('mantis_rest.ini', TRUE);

function get_config()
{
	global $config;
	return $config;
}
