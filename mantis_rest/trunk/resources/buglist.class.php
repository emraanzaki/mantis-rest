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

	public function get($request)
	{
		/**
		 *      Returns the Response with a list of bug URIs.
		 *
		 *      @param $request - The Request we're responding to
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

		$resp = new Response();
		$resp->status = 200;
		$resp->body = $this->repr($request);
		return $resp;
	}

	public function put($request)
	{
		method_not_allowed("PUT", array("GET", "POST"));
	}

	public function post($request)
	{
		/**
		 * 	Creates a new bug.
		 *
		 * 	Sets the location header and returns the main URL of the created resource,
		 * 	as RFC2616 says we SHOULD.
		 *
		 * 	@param $request - The Request we're responding to
		 */
		# This is all copied from Mantis's bug_report.php.
		$new_bug = new Bug;
		$new_bug->populate_from_repr();
		$new_bugdata = $new_bug->to_bugdata();
		if (!access_has_project_level(config_get('report_bug_threshold'),
				$new_bug->project_id)) {
			throw new HTTPException(403, "Access denied to report bug");
		}
		$new_bug_id = bug_create($new_bugdata);
		
		if ($new_bug_id) {
			$new_bug_url = Bug::get_url_from_mantis_id($new_bug_id);
			$this->rsrc_data = $new_bug_url;

			$resp = new Response();
			$resp->status = 201;
			$resp->headers[] = "location: $new_bug_url";
			$resp->body = $this->repr($request);
			return $resp;
		} else {
			throw new HTTPException(500, "Failed to create bug");
		}
	}
}
?>
