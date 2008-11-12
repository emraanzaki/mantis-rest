<?php
class BugList extends Resource
{
	/**
	 *      A list of Mantis bugs.
	 */
	function __construct() {
		$this->uri = $GLOBALS['cfg_api_url'] . '/bugs';
	}

	public function get()
	{
		/**
		 *      Returns the list of bug URIs.
		 */

		$bug_table = config_get('mantis_bug_table');
		$query = "SELECT b.id
			  FROM $bug_table b;";
		$result = db_query($query);
		$this->data = array();
		foreach ($result as $row) {
			$this->data[] = $this->uri . '/' . $row[0];
		}
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}
}
?>
