<?php
	require_once('config_inc.php');
	require_once($GLOBALS['cfg_mantis_root'] . '/core.php');

	function __autoload($class)
	{
		$class = strtolower($class);
		require_once("resources/$class.class.php");
	}

	function http_error($code, $message)
	{
		header("HTTP/1.1 $code");
		echo $message . "\n";
		exit;
	}

	function method_not_allowed($method)
	{
		http_error(405, "The method $method can't be used on this resource");
	}

	function content_type()
	{
		/**
		 *	Returns the content type we'll return, throwing an HTTP error if we can't.
		 */
		$headers = getallheaders();
		$type = array_key_exists('Accept', $headers)
						? $headers['Accept']
						: 'text/x-json';
		if ($type == 'text/x-json' || $type == 'application/json') {
			return $type;
		} else {
			http_error(406, "Unacceptable content type: $type.  This resource is available in the following content types:

text/xjson
application/json");
		}
	}

	function get_string_to_enum($enum_string, $string)
	{
		/**
		 * 	Gets Mantis's integer for the given string
		 *
		 * 	This is the inverse of Mantis's get_enum_to_string().  If the string is
		 * 	not found in the enum string, we return -1.
		 */
		if (preg_match('/^@.*@$/', $string)) {
			return substr($string, 1, -1);
		}
		$enum_array = explode_enum_string($enum_string);
		foreach ($enum_array as $pair) {
			$t_s = explode_enum_arr($pair);
			if ($t_s[1] == $string) {
				return $t_s[0];
			}
		}
		return -1;
	}

	function handle_error($errno, $errstr)
	{
		http_error(500, "Mantis encountered an error: " . error_string($errstr));
	}
	set_error_handler("handle_error", E_USER_ERROR);

	abstract class Resource
	{
		/**
		 * 	A REST resource; the abstract for all resources we serve.
		 */
		protected function repr()
		{
			/**
			 * 	Returns a representation of resource.
			 *
			 * 	@param $type - string - The mime type desired
			 */
			$type = content_type();
			if ($type == 'text/x-json' || $type == 'application/json') {
				return json_encode($this->rsrc_data);
			}
		}

		abstract public function get();	# Handles a GET request for the resource
		abstract public function put();	# Handles a PUT request
	}

	class RestService
	{
		/**
		 * 	A REST service.
		 */
		public function handle()
		{
			/**
			 * 	Handles the resource request.
			 */
			# In order to find out what kind of resource we're dealing with, we match
			# the path part of the URL against a sequence of regexes.
			$path = parse_url($this->url, PHP_URL_PATH);
			if (preg_match('!/users/?$!', $path)) {
				$resource = new UserList($this->url);
			} else if (preg_match('!/users/\d+/?$!', $path)) {
				$resource = new User($this->url);
			} else if (preg_match('!/bugs/?$!', $path)) {
				$resource = new BugList($this->url);
			} else if (preg_match('!/bugs/\d+/?$!', $path)) {
				$resource = new Bug($this->url);
			} else if (preg_match('!/bugs/\d+/notes/?$!', $path)) {
				$resource = new BugnoteList($this->url);
			} else if (preg_match('!/notes/\d+/?$!', $path) ||
				   preg_match('!/bugs/\d+/notes/\d+/?$!', $path)) {
				$resource = new Bugnote($this->url);
			} else {
				http_error(404, "No resource at this URL");
			}

			if ($this->method == 'GET') {
				header('Content-type', content_type());
				echo $resource->get();
			} else if ($this->method == 'PUT') {
				$retval = $resource->put();
				if ($retval) {
					header('Content-type', content_type());
					echo $retval;
				} else {
					header('HTTP/1.1 204');
				}
			}
		}
	}
?>
