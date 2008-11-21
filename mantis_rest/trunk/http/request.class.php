<?php
class Request
{
	/**
	 *	An HTTP request.
	 */
	public function populate_from_server()
	{
		/**
		 * 	Sets the Request's variables based on the incoming HTTP request.
		 */
		$this->url = $_SERVER['REQUEST_URI'];
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->username = $_SERVER['PHP_AUTH_USER'];
		$this->password = $_SERVER['PHP_AUTH_PW'];

		$parsed_url = parse_url($this->url);
		$this->host = $parsed_url['host'];
		$this->path = $parsed_url['path'];
		$this->query = $parsed_url['query'];

		$config = get_config();
		$api_loc = $config['paths']['api_location'];
		if (strpos($this->path, $api_loc) == 0) {
			$this->rsrc_path = str_replace($api_loc, '', $this->path);
		} else {
			http_error(500, "Requested path not inside API");
		}
	}
}
