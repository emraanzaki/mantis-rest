<?php
class User extends Resource
{
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
		$cols = array();
		for ($i = 0; $i < count($col_names); $i++) {
			$cols[$col_names[$i]] = $row[$i];
		}

		$this->data['username'] = $cols['username'];
		$this->data['password'] = "********";
		$this->data['realname'] = $cols['realname'];
		$this->data['email'] = $cols['email'];
		$this->data['date_created'] = $cols['date_created'];
		$this->data['last_visit'] = $cols['last_visit'];
		$this->data['enabled'] = !!$cols['enabled'];
		$this->data['protected'] = !!$cols['protected'];
		$this->data['access_level'] = $cols['access_level'];
		$this->data['login_count'] = $cols['login_count'];
		$this->data['lost_password_request_count'] =
						$cols['lost_password_request_count'];
		$this->data['failed_login_count'] = $cols['failed_login_count'];
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}
}
?>
