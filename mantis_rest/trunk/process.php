<?php
	require_once "mantis_rest_core.php";

	$request = new Request();
	$request->populate_from_server();
	if (!auth_attempt_script_login($request->username, $request->password)) {
		header('WWW-Authenticate: Basic realm="Mantis REST API"');
		http_error(401, "Invalid credentials");
	}

	$service = new RestService();
	$service->handle($request);
?>
