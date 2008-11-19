<?php
class BugList extends Resource
{
	/**
	 *      A list of Mantis bugs.
	 */
	function __construct()
	{
		$this->mantis_data = array();
		$this->rsrc_data = array();
	}

	private function _get_query_condition($key, $value)
	{
		if ($key == 'handler') {
			return "b.handler_id = " . ($value ?
				User::get_mantis_id_from_url($value) :
				0);
		} elseif ($key == 'reporter') {
			return "b.reporter_id = " . User::get_mantis_id_from_url($value);
		} elseif ($key == 'duplicate') {
			return "b.duplicate_id = " . Bug::get_mantis_id_from_url($value);
		} elseif (in_array($key, array('priority', 'severity', 'reproducibility',
					'status', 'resolution', 'projection', 'eta'))) {
			return "b.$key = " . get_string_to_enum(config_get($key."_enum_string"),
				$value);
		}
		return "";
	}

	public function get()
	{
		/**
		 *      Returns the list of bug URIs.
		 */
		$conditions = array();
		foreach ($_GET as $k => $v) {
			$condition = $this->_get_query_condition($k, $v);
			if ($condition) {
				$conditions[] = $condition;
			}
		}

		$bug_table = config_get('mantis_bug_table');
		$query = "SELECT b.id
			  FROM $bug_table b";
		if ($conditions) {
			$query .= " WHERE ";
			$query .= implode(" AND ", $conditions);
		}
		$query .= ";";

		$result = db_query($query);
		$row = db_fetch_array($result);
		$this->rsrc_data['results'] = array();
		foreach ($result as $row) {
			$this->rsrc_data['results'][] = Bug::get_url_from_mantis_id($row[0]);
		}
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}
}
?>
