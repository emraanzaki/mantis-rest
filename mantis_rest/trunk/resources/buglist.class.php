<?php
class BugList extends ResourceList
{
	/**
	 *      A list of Mantis bugs.
	 */
	function __construct()
	{
		$this->mantis_data = array();
		$this->rsrc_data = array();
	}

	protected function _get_query_condition($key, $value)
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
		return NULL;
	}

	protected function _get_query_order($key, $value)
	{
		/**
		 * 	Returns an ORDER BY argument, given an argument from the query string.
		 *
		 * 	The return value of this function goes right after an 'ORDER BY', so it
		 * 	might be 'b.reporter ASC' or 'u.date_created DESC'.
		 *
		 * 	@param $key - The resource attribute on which the request says to sort.  For
		 * 		example, if the QS parameter is 'sort-priority', $key here will be
		 * 		'priority'.
		 * 	@param $value - The sense of the sort; 1 for ascending, -1 for descending.
		 */
		if ($key == 'handler' || $key == 'reporter' || $key == 'duplicate') {
			$key .= '_id';
		} elseif ($key == 'private') {
			$key = 'view_state';
		} elseif (in_array($key, Bug::$rsrc_attrs)) {
			$key = mysql_escape_string($key);
		} else {
			throw new HTTPException(500, "Can't sort by unknown attribute '$key'");
		}
		$sql = "b.$key";

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
		 *      Returns the Response with a list of bug URIs.
		 *
		 *      @param $request - The Request we're responding to
		 */

		# First we use Mantis's filter API to get all the bugs visible to the user.
		$page_num = 1;
		$per_page = 0;
		$page_count = 0;
		$bug_count = 0;
		$custom_filter = filter_get_default();
		$rows = filter_get_bug_rows($page_num, $per_page, $page_count, $bug_count,
			$custom_filter);
		$visible_bug_ids = array();
		foreach ($rows as $r) {
			$visible_bug_ids[] = $r[0];
		}

		# Now we construct a query to figure out which of these bugs matches the conditions
		# we got from the query string, and order them correctly.
		$sql_to_add = $this->_build_sql_from_querystring($request->query);
		$bug_ids = array();
		if ($sql_to_add) {
			$mantis_bug_table = config_get('mantis_bug_table');
			$query = "SELECT b.id FROM $mantis_bug_table b $sql_to_add;";

			$result = db_query($query);
			# This loop takes care of both the filtering and the sorting.
			foreach ($result as $r) {
				if (in_array($r[0], $visible_bug_ids)) {
					$bug_ids[] = $r[0];
				}
			}
		} else {
			$bug_ids = $visible_bug_ids;
		}

		$this->rsrc_data['results'] = array();
		foreach ($bug_ids as $id) {
			$this->rsrc_data['results'][] = Bug::get_url_from_mantis_id($id);
		}

		$resp = new Response();
		$resp->status = 200;
		$resp->body = $this->_repr($request);
		return $resp;
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
		$new_bug->populate_from_repr($request->body);
		$new_bugdata = $new_bug->to_bugdata();
		if (!access_has_project_level(config_get('report_bug_threshold'),
				$new_bugdata->project_id)) {
			throw new HTTPException(403, "Access denied to report bug");
		}
		$new_bug_id = bug_create($new_bugdata);
		email_new_bug($new_bug_id);
		
		if ($new_bug_id) {
			$new_bug_url = Bug::get_url_from_mantis_id($new_bug_id);
			$this->rsrc_data = $new_bug_url;

			$resp = new Response();
			$resp->status = 201;
			$resp->headers[] = "location: $new_bug_url";
			$resp->body = $this->_repr($request);
			return $resp;
		} else {
			throw new HTTPException(500, "Failed to create bug");
		}
	}
}
