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
				return json_encode($this->data);
			}
		}

		abstract public function get();	# Handles a GET request for the resource
		abstract public function put();	# Handles a PUT request
	}

	class ResourceElement
	{
		/**
		 * 	An element of a resource.
		 *
		 * 	This class handles the conversion between Mantis data and resource data.
		 * 	You can specify $resource_cls, $enum_name, or neither.  Using both is not
		 * 	supported.
		 *
		 * 	Specifying $resource_cls means that Mantis stores the value as the (integer)
		 * 	ID of a database entity represented by the given class.  We will therefore
		 * 	convert this ID to a URL for the representation, and convert a URL to a
		 * 	Mantis ID when given a representation.
		 *
		 * 	If you specify $enum_name, it means that Mantis stores an integer for the
		 * 	value, which is referenced in the given enumerator.  We'll convert the
		 * 	integer to a word in the default language, and vice versa.
		 *
		 * 	@param $mantis_name - The name Mantis uses for this value (in its DB)
		 * 	@param $outward_name - The name we use for this value in representations
		 * 	@param $resource_cls - The name of the class of the resource
		 * 	@param $enum_name - The name of the enumerator from which this data comes
		 */
		function __construct($mantis_name, $outward_name, $resource_cls = '',
				     $enum_name = '')
		{
			$this->mantis_name = $mantis_name;
			$this->outward_name = $outward_name;
			$this->_resource_cls = $resource_cls;
			$this->_enum_string = $enum_name ? config_get($enum_name) : '';
		}

		function mantis_to_resource($mantis_value) {
			if ($this->_resource_cls) {
				$func = "$this->_resource_cls::get_url_from_mantis_id";
				return $func($mantis_value);
			} else if($this->_enum_string) {
				return get_enum_to_string($this->_enum_string, $mantis_value);
			} else {
				return $mantis_value;
			}
		}

		function resource_to_mantis($resource_value) {
			if ($this->_resource_cls) {
				$func = "$this->_resource_cls::get_mantis_id_from_url";
				return $func($resource_value);
			} else if ($this->_enum_string) {
				return get_string_to_enum($this->_enum_string, $resource_value);
			} else {
				return $resource_value;
			}
		}
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
			if (preg_match('!/users/?$!', $this->url)) {
				$resource = new UserList($this->url);
			} else if (preg_match('!/users/\d+/?$!', $this->url)) {
				$resource = new User($this->url);
			} else if (preg_match('!/bugs/?$!', $this->url)) {
				$resource = new BugList($this->url);
			} else if (preg_match('!/bugs/\d+/?$!', $this->url)) {
				$resource = new Bug($this->url);
			} else if (preg_match('!/bugs/\d+/notes/?$!', $this->url)) {
				$resource = new BugNoteList($this->url);
			} else if (preg_match('!/notes/\d+/?$!', $this->url) ||
				   preg_match('!/bugs/\d+/notes/\d+/?$!')) {
				$resource = new BugNote($this->url);
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
