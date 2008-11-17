<?php
class User extends Resource
{
	public static $mantis_attrs = array('username', 'password', 'realname', 'email',
		'date_created', 'last_visit', 'enabled', 'protected', 'access_level', 'login_count',
		'lost_password_request_count', 'failed_login_count');
	public static $rsrc_attrs = array('username', 'password', 'realname', 'email',
		'date_created', 'last_visit', 'enabled', 'protected', 'access_level', 'login_count',
		'lost_password_request_count', 'failed_login_count');

	static function get_url_from_mantis_id($user_id)
	{
		/**
		 *      Returns the URL for the resource corresponding to the user with the
		 *      given Mantis user ID.
		 */
		return $GLOBALS['cfg_api_url'] . "/$user_id";
	}

	static function get_mantis_id_from_url($url)
	{
		$matches = array();
		if (preg_match('!/(\d+)!', $url, &$matches)) {
			return $matches[1];
		} else {
			http_error(404, "Unknown user '$matches[1]'");
		}
	}

	function __construct($url)
	{
		$this->user_id = User::get_mantis_id_from_url($url);

		$this->mantis_data = array();
		$this->rsrc_data = array();
	}

	private function _get_mantis_attr($attr_name)
	{
		if ($attr_name == 'enabled' || $attr_name == 'protected') {
			return $this->rsrc_data[$attr_name] ? 1 : 0;
		} elseif (in_array($attr_name, User::$mantis_attrs)) {
			return ($this->rsrc_data[$attr_name]);
		} elseif ($attr_name == 'access_level') {
			return get_string_to_enum(config_get('access_levels_enum_string'),
				$this->rsrc_data[$attr_name]);
		} elseif ($attr_name == 'date_created' || $attr_name == 'last_visit') {
			return date_to_sql_date($this->rsrc_data[$attr_name]);
		} else {
			http_error(415, "Unknown resource attribute: $attr_name");
		}
	}

	private function _get_rsrc_attr($attr_name)
	{
		if ($attr_name == 'password') {
			return '********';
		} elseif ($attr_name == 'enabled' || $attr_name == 'protected') {
			return !!$this->mantis_data[$attr_name];
		} elseif ($attr_name == 'access_level') {
			return get_enum_to_string(config_get('access_levels_enum_string'),
				$this->mantis_data['access_level']);
		} elseif ($attr_name == 'date_created' || $attr_name == 'last_visit') {
			return date_to_iso_date($this->mantis_data[$attr_name]);
		} elseif (in_array($attr_name, array('login_count',
			'lost_password_request_count',
			'failed_login_count'))) {
			return (int)$this->$attr_name;
		} else {
			return $this->mantis_data[$attr_name];
		}
	}

	public function get()
	{
		/**
		 *      Returns a representation of the user.
		 */
		if (!access_has_global_level(config_get('manage_user_threshold'))
				&& auth_get_current_user_id() != $this->user_id) {
			http_error(403, "Access denied to user $this->user_id's info");
		}

		$user_table = config_get('mantis_user_table');
		$query = "SELECT u.username,
				 u.realname,
				 u.email,
				 u.date_created,
				 u.last_visit,
				 u.enabled,
				 u.protected,
				 u.access_level,
				 u.login_count,
				 u.lost_password_request_count,
				 u.failed_login_count
			  FROM $user_table u
			  WHERE u.id='$this->user_id'";
		$result = db_query($query);
		if (db_num_rows($result) == 0) {
			http_error(404, "No user exists with ID $this->user_id");
		}

		$row = db_fetch_array($result);
		$col_names = array('username', 'realname', 'email', 'date_created',
				   'last_visit', 'enabled', 'protected', 'access_level',
				   'login_count', 'lost_password_request_count',
				   'failed_login_count');
		for ($i = 0; $i < count($col_names); $i++) {
			$this->mantis_data[$col_names[$i]] = $row[$i];
		}
		foreach (User::$rsrc_attrs as $a) {
			$this->rsrc_data[$a] = $this->_get_rsrc_attr($a);
		}
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}
}
?>
