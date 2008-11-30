<?php
	$config = parse_ini_file('mantis_rest.ini', TRUE);
	require_once($config['mantis']['root'] . '/core.php');

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

	function get_config()
	{
		global $config;
		return $config;
	}

	function method_not_allowed($method, $allowed)
	{
		/**
		 * 	Errors out when a method is not allowed on a resource.
		 *
		 * 	We set the Allow header, which is a MUST according to RFC 2616.
		 *
		 * 	@param $method - The method that's not allowed
		 * 	@param $allowed - An array containing the methods that are allowed
		 */
		throw new HTTPException(405, "The method $method can't be used on this resource",
			array("allow: " . implode(", ", $allowed)));
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
		throw new HTTPException(500, "Mantis encountered an error: " . error_string($errstr));
		$resp->send();
		exit;
	}
	set_error_handler("handle_error", E_USER_ERROR);

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

	class RestService
	{
		/**
		 * 	Our REST service.
		 */
		public function handle($request)
		{
			/**
			 * 	Handles the resource request.
			 *
			 * 	@param $request - A Request object
			 * 	@param $return_response - If given, we return the Response object
			 * 		instead of sending it.
			 */
			if (!auth_attempt_script_login($request->username, $request->password)) {
				throw new HTTPException(401, "Invalid credentials", array(
					'WWW-Authenticate: Basic realm="Mantis REST API"'));
			}

			$path = $request->rsrc_path;
			if (preg_match('!^/users/?$!', $path)) {
				$resource = new UserList();
			} elseif (preg_match('!^/users/\d+/?$!', $path)) {
				$resource = new User();
			} elseif (preg_match('!^/bugs/?$!', $path)) {
				$resource = new BugList();
			} elseif (preg_match('!^/bugs/\d+/?$!', $path)) {
				$resource = new Bug();
			} elseif (preg_match('!^/bugs/\d+/notes/?$!', $path)) {
				$resource = new BugnoteList($request->url);
			} elseif (preg_match('!^/notes/\d+/?$!', $path)) {
				$resource = new Bugnote();
			} else {
				throw new HTTPException(404, "No resource at this URL");
			}

			if ($request->method == 'GET') {
				$resp = $resource->get($request);
			} elseif ($request->method == 'PUT') {
				$resp = $resource->put($request);
			} elseif ($request->method == 'POST') {
				$resp = $resource->post($request);
			} else {
				throw new HTTPException(501, "Unrecognized method: $request->method");
			}

			return $resp;
		}
	}
