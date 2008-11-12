<?php
	require_once "mantis_rest_core.php";

	$service = new RestService();
	$service->url = $_SERVER['REQUEST_URI'];
	$service->method = $_SERVER['REQUEST_METHOD'];
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="Mantis REST API"');
		http_error(401, "Unauthorized");
	}
	$service->username = $_SERVER['PHP_AUTH_USER'];
	$service->password = $_SERVER['PHP_AUTH_PW'];
	if (!auth_attempt_script_login($service->username, $service->password)) {
		header('WWW-Authenticate: Basic realm="Mantis REST API"');
		http_error(401, "Invalid credentials");
	}
	$service->uid = user_get_id_by_name($service->username);
	$service->gets = $_GET;
	$service->posts = $_POST;

	$service->handle();
?>
