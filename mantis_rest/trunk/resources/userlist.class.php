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
}
?>
