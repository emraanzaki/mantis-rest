<?php
class UserList extends Resource
{
	function __construct($url)
	{
		$config = get_config();
		$this->canonical_url = $config['paths']['api_url'] . '/users';
		$this->mantis_data = array();
		$this->rsrc_data = array();
	}

	private function _get_query_condition($key, $value)
	{
		if ($key == 'username') {
			if (user_is_name_valid($value)) {
				return "u.username = '$value'";
			} else {
				return "1 = 0";
			}
		}
		return "";
	}

	public function get()
	{
		/**
		 *      Returns the list of user URIs.
		 */
		if (!access_has_global_level(config_get('manage_user_threshold'))) {
			http_error(403, "Access denied to user list");
		}

		$conditions = array();
		foreach ($_GET as $k => $v) {
			$condition = $this->_get_query_condition($k, $v);
			if ($condition) {
				$conditions[] = $condition;
			}
		}

		$user_table = config_get('mantis_user_table');
		$query = "SELECT u.id
			  FROM $user_table u";
		if ($conditions) {
			$query .= " WHERE ";
			$query .= implode(" AND ", $conditions);
		}
		$query .= ";";

		$result = db_query($query);
		$row = db_fetch_array($result);
		$this->rsrc_data['results'] = array();
		foreach ($result as $row) {
			$this->rsrc_data['results'][] = User::get_url_from_mantis_id($row[0]);
		}
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}

	public function post()
	{
		/**
		 * 	Creates a new user.
		 *
		 * 	The user will get a confirmation email, and will have the password provided
		 * 	in the incoming representation.
		 */
		if (!access_has_global_level(config_get('manage_user_threshold'))) {
			http_error(403, "Access denied to create user");
		}

		$new_user = new User;
		$new_user->populate_from_repr();

		$username = $new_user->mantis_data['username'];
		$password = $new_user->mantis_data['password'];
		$email = email_append_domain($new_user->mantis_data['email']);
		$access_level = $new_user->mantis_data['access_level'];
		$protected = $new_user->mantis_data['protected'];
		$enabled = $new_user->mantis_data['enabled'];
		$realname = $new_user->mantis_data['realname'];

		if (!user_is_name_valid($username)) {
			http_error(500, "Invalid username");
		} elseif (!user_is_realname_valid($realname)) {
			http_error(500, "Invalid realname");
		}
		user_create($username, $password, $email, $access_level, $protected, $enabled,
			$realname);

		$new_user_id = user_get_id_by_name($username);
		$new_user_url = User::get_url_from_mantis_id($new_user_id);
		header('location',  $new_user_url);
		$this->rsrc_data = $new_user_url;
		return $this->repr();
	}	
}
?>
