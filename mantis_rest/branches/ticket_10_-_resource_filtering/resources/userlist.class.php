<?php
class UserList extends Resource
{
	function __construct($url)
	{
		$this->canonical_url = $GLOBALS['cfg_api_url'] . '/users';
	}

	public function get()
	{
		/**
		 *      Returns the list of user URIs.
		 */
		if (!access_has_global_level(config_get('manage_user_threshold'))) {
			http_error(403, "Access denied to user list");
		}

		$user_table = config_get('mantis_user_table');
		$query = "SELECT u.id
			  FROM $user_table u;";
		$result = db_query($query);
		$this->data = array();
		foreach ($result as $row) {
			$this->data[] = $this->canonical_url . '/' . $row[0];
		}
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}
}
?>
