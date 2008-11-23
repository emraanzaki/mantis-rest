<?php
class Request
{
	/**
	 *	An HTTP request.
	 */
	public function populate($url, $method, $username, $password, $type_expected='text/x-json')
	{
		$this->url = $url;
		$this->method = $method;
		$this->username = $username;
		$this->password = $password;
		$this->type_expected = $type_expected;

		$this->_extrapolate_from_url();
	}

	public function populate_from_server()
	{
		/**
		 * 	Sets the Request's variables based on the incoming HTTP request.
		 */
		$this->url = $_SERVER['REQUEST_URI'];
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->username = $_SERVER['PHP_AUTH_USER'];
		$this->password = $_SERVER['PHP_AUTH_PW'];

		$this->_extrapolate_from_url();

		$headers = getallheaders();
		$type = array_key_exists('Accept', $headers)
						? $headers['Accept']
						: 'text/x-json';
		if ($type == 'text/x-json' || $type == 'application/json') {
			$this->type_expected = $type;
		} else {
			throw new HTTPException(406, "Unacceptable content type: $type.  This resource is available in the following content types:

text/x-json
application/json");
		}
	}

	private function _extrapolate_from_url()
	{
		/**
		 * 	Fills in a few extra variables once the URL has been set.
		 */
	
		$parsed_url = parse_url($this->url);
		$this->host = $parsed_url['host'];
		$this->path = $parsed_url['path'];
		$this->query = $parsed_url['query'];

		$config = get_config();
		$api_loc = $config['paths']['api_location'];
		if (strpos($this->path, $api_loc) == 0) {
			$this->rsrc_path = str_replace($api_loc, '', $this->path);
		} else {
			throw new HTTPException(500, "Requested path not inside API");
		}
	}
}
