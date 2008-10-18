<?php
class BugNote extends Resource
{
	/*
	 *      A bug note.
	 */
	function __construct($url)
	{
		/*
		 *      Constructs the note.
		 *
		 *      @param $url - The URL with which this resource was requested
		 */
		$matches = array();
		if (preg_match('!/notes/(\d+)/?!', $url, &$matches)) {
			$this->note_id = $matches[1];
		} else {
			http_error(404, "No such bug note: $matches[1]");
		}
	}

	public function get()
	{
		/*
		 *      Returns a representation of the note.
		 */
		if (!bugnote_exists($this->note_id)) {
			http_error(404, "No such bug note: $this->note_id");
		}
		if (!access_has_bugnote_level(VIEWER, $this->note_id)) {
			http_error(403, "Access denied");
		}

		$bugnote_table = config_get('mantis_bugnote_table');
		$bugnote_text_table = config_get('mantis_bugnote_text_table');
		$query = "SELECT n.bug_id,
				 n.reporter_id,
				 nt.note,
				 n.view_state,
				 n.date_submitted,
				 n.last_modified
			  FROM $bugnote_table n
			  INNER JOIN $bugnote_text_table nt
				ON n.bugnote_text_id = nt.id
			  WHERE n.id = $this->note_id;";
		$result = db_query($query);
		$row = db_fetch_array($result);

		$col_names = array('bug_id', 'reporter_id', 'note', 'view_state',
				   'date_submitted', 'last_modified');
		$cols = array();
		for ($i = 0; $i < count($col_names); $i++) {
			$cols[$col_names[$i]] = $row[$i];
		}

		$this->data['bug'] = Bug::get_url_from_mantis_id($cols['bug_id']);
		$this->data['reporter'] = User::get_url_from_mantis_id($cols['reporter_id']);
		$this->data['note'] = $cols['note'];
		$this->data['private'] = !!($cols['view_state'] == VS_PRIVATE);
		$this->data['date_submitted'] = $cols['date_submitted'];
		$this->data['last_modified'] = $cols['last_modified'];
		return $this->repr();
	}

	public function put()
	{
		method_not_allowed("PUT");
	}
}
?>
