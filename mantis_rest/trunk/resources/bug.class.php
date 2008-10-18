<?php
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

		$this->data = bug_get($this->bug_id, true);
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

		$bug_data = new BugData();
		foreach ($new_data as $k => $v) {
			if ($k == 'reporter') {
				$bug_data->reporter_id = User::get_mantis_id_from_url($v);
			} else if ($k == 'handler') {
				if ($v) {
					$bug_data->handler_id =
							User::get_mantis_id_from_url($v);
				} else {
					$bug_data->handler_id = 0;
				}
			} else if ($k == 'duplicate') {
				if ($v) {
					$bug_data->duplicate_id =
							Bug::get_mantis_id_from_url($v);
				} else {
					$bug_data->duplicate_id = 0;
				}
			} else {
				$bug_data->$k = $v;
			}
		}

		bug_update($this->bug_id, $bug_data);
	}
}
?>
