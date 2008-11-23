<?php
require_once "mantis_rest_core.php";

$request = new Request();
$request->populate_from_server();

$service = new RestService();
try {
	$resp = $service->handle($request);
	$resp->send();
} catch (HTTPException $e) {
	$e->resp->send();
}
