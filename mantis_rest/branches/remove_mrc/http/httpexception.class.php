<?php
class HTTPException extends Exception
{
	function __construct($status, $message, $headers=NULL)
	{
		$this->resp = new Response();
		$this->resp->status = $status;
		$this->resp->body = $message;
		if (!is_null($headers)) {
			$this->resp->headers = $headers;
		}
	}
}
