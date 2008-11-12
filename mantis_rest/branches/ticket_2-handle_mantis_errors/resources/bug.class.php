<?php
require_once('mantis_rest_core.php');
class Bug extends Resource
{
	/**
	 *      A Mantis bug.
	 */
	static function get_url_from_mantis_id($bug_id)
	{
		return $GLOBALS['cfg_api_url'] . "/bugs/$bug_id";
	}

	static function get_mantis_id_from_url($url)
	{
		$matches = array();
		if (preg_match('!/(\d+)/?$!', $url, &$matches)) {
			return (int)$matches[1];
		} else {
			http_error(404, "No such bug: $matches[1]");
		}
	}

	static function get_resource_from_db_row($row)
	{
		/**
		 * 	Given a row (object) from the bug table, return a hash to be the resource.
		 */
		return array(
			'project_id' => $row->project_id,
			'reporter_id' => User::get_url_from_mantis_id($row->reporter_id),
			'handler_id' => $row->handler_id ?
				User::get_url_from_mantis_id($row->handler_id) :
				"",
			'duplicate_id' => $row->duplicate_id ?
				User::get_url_from_mantis_id($row->duplicate_id) :
				"",
			'priority' => get_enum_to_string(config_get('priority_enum_string'),
				$row->priority),
			'severity' => get_enum_to_string(config_get('severity_enum_string'),
				$row->severity),
			'reproducibility' =>
				get_enum_to_string(config_get('reproducibility_enum_string'),
					$row->reproducibility),
			'status' => get_enum_to_string(config_get('status_enum_string'),
				$row->status),
			'resolution' => get_enum_to_string(config_get('resolution_enum_string'),
				$row->resolution),
			'projection' => get_enum_to_string(config_get('projection_enum_string'),
				$row->projection),
			'category' => $row->category,
			'date_submitted' => $row->date_submitted,
			'last_updated' => $row->last_updated,
			'eta' => get_enum_to_string(config_get('eta_enum_string'), $row->eta),
			'os' => $row->os,
			'os_build' => $row->os_build,
			'platform' => $row->platform,
			'version' => $row->version,
			'fixed_in_version' => $row->fixed_in_version,
			'target_version' => $row->target_version,
			'build' => $row->build,
			'private' => $row->view_state == VS_PRIVATE,
			'summary' => $row->summary,
			'profile_id' => $row->profile_id,
			'description' => $row->description,
			'steps_to_reproduce' => $row->steps_to_reproduce,
			'additional information' => $row->additional_information
		);
	}

	static function get_db_row_from_resource($rsrc)
	{
		/**
		 * 	Given a Bug resource, return an object to serve as a database row for it.
		 */
		$bug = new BugData();
		$bug->project_id = $rsrc['project_id'];
		$bug->reporter_id = User::get_mantis_id_from_url($rsrc['reporter']);
		$bug->handler_id = $rsrc['handler'] ?
			User::get_mantis_id_from_url($rsrc['handler']):
			"";
		$bug->duplicate_id = $rsrc['duplicate'] ?
			Bug::get_mantis_id_from_url($rsrc['duplicate']):
			"";
		$bug->priority = get_string_to_enum(config_get('priority_enum_string'),
			$rsrc['priority']);
		$bug->severity = get_string_to_enum(config_get('severity_enum_string'),
			$rsrc['severity']);
		$bug->reproducibility = get_string_to_enum(
			config_get('reproducibility_enum_string'),
				$rsrc['reproducibility']);
		$bug->status = get_string_to_enum(config_get('status_enum_string'),
			$rsrc['status']);
		$bug->resolution = get_string_to_enum(config_get('resolution_enum_string'),
			$rsrc['resolution']);
		$bug->projection = get_string_to_enum(config_get('projection_enum_string'),
			$rsrc['projection']);
		$bug->category = $rsrc['category'];
		$bug->date_submitted = $rsrc['date_submitted'];
		$bug->last_updated = $rsrc['last_updated'];
		$bug->os = $rsrc['os'];
		$bug->os_build = $rsrc['os_build'];
		$bug->platform = $rsrc['platform'];
		$bug->version = $rsrc['version'];
		$bug->fixed_in_version = $rsrc['fixed_in_version'];
		$bug->target_version = $rsrc['target_version'];
		$bug->build = $rsrc['build'];
		$bug->private = $rsrc['private'] ? VS_PRIVATE : VS_PUBLIC;
		$bug->summary = $rsrc['summary'];
		$bug->profile_id = $rsrc['profile_id'];
		$bug->description = $rsrc['description'];
		$bug->steps_to_reproduce = $rsrc['steps_to_reproduce'];
		$bug->additional_information = $rsrc['additional_information'];
		foreach (get_object_vars($bug) as $k => $v) {
			header("x-bug-stuff: $k: $v", FALSE);
		}
		return $bug;
	}

	function __construct($url)
	{
		/**
		 *      Constructs the bug.
		 *
		 *      @param $url - The URL with which this resource was requested
		 */
		$this->bug_id = Bug::get_mantis_id_from_url($url);
	}

	public function get()
	{
		/*
		 *      Returns a representation of the bug.
		 */
		if (!bug_exists($this->bug_id)) {
			http_error(404, "No such bug: $this->bug_id");
		}
		if (!access_has_bug_level(VIEWER, $this->bug_id)) {
			http_error(403, "Permission denied");
		}

		$bug_data = bug_get($this->bug_id, true);
		$this->data = Bug::get_resource_from_db_row($bug_data);
		return $this->repr();
	}

	public function put()
	{
		/*
		 *      Replaces the bug resource using the representation provided.
		 *
		 *      Returns the content, if any, that should be returned to the client.
		 */
		$new_rep = file_get_contents('php://input');
		$new_data = json_decode($new_rep, true);

		$bug_data = BugNote::get_db_row_from_resource($new_data);
		bug_update($this->bug_id, $bug_data, true);
	}
}
?>
