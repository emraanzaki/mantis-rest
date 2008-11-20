<?php
	$config = parse_ini_file('mantis_rest.ini', TRUE);
	require_once($config['mantis']['root'] . '/core.php');

	function __autoload($class)
	{
		$class = strtolower($class);
		require_once("resources/$class.class.php");
	}

	function get_config()
	{
		global $config;
		return $config;
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

text/x-json
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

	function date_to_timestamp($iso_date)
	{
		/**
		 *	Returns a UNIX timestamp for the given date.
		 *
		 *	@param $iso_date - A string containing a date in ISO 8601 format
		 */
		return strtotime($iso_date);
	}

	function timestamp_to_iso_date($timestamp)
	{
		/**
		 *	Returns an ISO 8601 date for the given timestamp.
		 *
		 *	@param $timestamp - The timestamp.
		 */
		return date('c', $timestamp);
	}

	function date_to_iso_date($date)
	{
		return date('c', strtotime($date));
	}

	function date_to_sql_date($date)
	{
		return date('Y-m-d H:i:s', strtotime($date));
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
			} elseif (preg_match('!/users/\d+/?$!', $path)) {
				$resource = new User($this->url);
			} elseif (preg_match('!/bugs/?$!', $path)) {
				$resource = new BugList($this->url);
			} elseif (preg_match('!/bugs/\d+/?$!', $path)) {
				$resource = new Bug($this->url);
			} elseif (preg_match('!/bugs/\d+/notes/?$!', $path)) {
				$resource = new BugnoteList($this->url);
			} elseif (preg_match('!/notes/\d+/?$!', $path) ||
				   preg_match('!/bugs/\d+/notes/\d+/?$!', $path)) {
				$resource = new Bugnote($this->url);
			} else {
				http_error(404, "No resource at this URL");
			}

			if ($this->method == 'GET') {
				header('Content-type', content_type());
				echo $resource->get();
			} elseif ($this->method == 'PUT') {
				$retval = $resource->put();
				if ($retval) {
					header('Content-type', content_type());
					echo $retval;
				} else {
					header('HTTP/1.1 204');
				}
			} elseif ($this->method == 'POST') {
				$retval = $resource->post();
				if ($retval) {
					header('Content-type', content_type());
					echo $retval;
				} else {
					header('HTTP/1.1 201');
				}
			}
		}
	}
?>
