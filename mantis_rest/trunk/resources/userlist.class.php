<?php
class UserList extends ResourceList
{
	function __construct()
	{
		$config = get_config();
		$this->mantis_data = array();
		$this->rsrc_data = array();
	}

	protected function _get_query_condition($key, $value)
	{
		if ($key == 'access_level') {
			$value = get_string_to_enum(
				config_get('access_levels_enum_string'), $value);
			return "u.$key = $value";
		} elseif ($key == 'enabled' || $key == 'protected') {
			$value = ON;
			return "u.$key = $value";
		} elseif (in_array($key, explode(' ', 'username realname email'))) {
			$value = mysql_escape_string($value);
			return "u.$key = '$value'";
		} else {
			throw new HTTPException(500, "Can't filter users by attribute '$key'");
		}
	}

	protected function _get_query_order($key, $value)
	{
		if (!in_array($key, array('username', 'realname', 'email', 'date_created',
			'last_visit', 'access_level', 'login_count', 'lost_password_request_count',
			'failed_login_count'))) {
				throw new HTTPException(500,
					"Can't sort users by attribute '$key'");
		}
		$sql = "u.$key";

		if ($value == 1) {
			$sql .= ' ASC';
		} elseif ($value == -1) {
			$sql .= ' DESC';
		}

		return $sql;
	}

	public function get($request)
	{
		/**
		 *      Returns a Response with the list of user URIs.
		 *
		 *      @param $request - The Request we're responding to
		 */
		if (!access_has_global_level(config_get('manage_user_threshold'))) {
			throw new HTTPException(403, "Access denied to user list");
		}

		$sql_to_add = $this->_build_sql_from_querystring($request->query);
/*		$conditions = array();
		parse_str($request->query, $qs_pairs);
		foreach ($qs_pairs as $k => $v) {
			$condition = $this->_get_query_condition($k, $v);
			if ($condition) {
				$conditions[] = $condition;
			}
		} */

		$user_table = config_get('mantis_user_table');
		$query = "SELECT u.id
			FROM $user_table u
			$sql_to_add;";

		$result = db_query($query);
		$row = db_fetch_array($result);
		$this->rsrc_data['results'] = array();
		foreach ($result as $row) {
			$this->rsrc_data['results'][] = User::get_url_from_mantis_id($row[0]);
		}

		$resp = new Response();
		$resp->status = 200;
		$resp->body = $this->_repr($request);
		return $resp;
	}

	public function post($request)
	{
		/**
		 * 	Creates a new user.
		 *
		 * 	The user will get a confirmation email, and will have the password provided
		 * 	in the incoming representation.
		 *
		 * 	@param $request - The Request we're responding to
		 */
		if (!access_has_global_level(config_get('manage_user_threshold'))) {
			throw new HTTPException(403, "Access denied to create user");
		}

		$new_user = new User;
		$new_user->populate_from_repr($request->body);

		$username = $new_user->mantis_data['username'];
		$password = $new_user->mantis_data['password'];
		$email = email_append_domain($new_user->mantis_data['email']);
		$access_level = $new_user->mantis_data['access_level'];
		$protected = $new_user->mantis_data['protected'];
		$enabled = $new_user->mantis_data['enabled'];
		$realname = $new_user->mantis_data['realname'];

		if (!user_is_name_valid($username)) {
			throw new HTTPException(500, "Invalid username");
		} elseif (!user_is_realname_valid($realname)) {
			throw new HTTPException(500, "Invalid realname");
		}
		user_create($username, $password, $email, $access_level, $protected, $enabled,
			$realname);

		$new_user_id = user_get_id_by_name($username);
		$new_user_url = User::get_url_from_mantis_id($new_user_id);
		$this->rsrc_data = $new_user_url;

		$resp = new Response();
		$resp->status = 201;
		$resp->headers[] = "location: $new_user_url";
		$resp->body =  $this->_repr($request);
		return $resp;
	}	
}
?>
