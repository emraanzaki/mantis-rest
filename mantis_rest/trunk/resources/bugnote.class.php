<?php
class BugNote extends Resource
{
	/**
	 *      A bug note.
	 */
	function __construct($url)
	{
		/**
		 *      Constructs the note.
		 *
		 *      @param $url - The URL with which this resource was requested
		 */
		$matches = array();
		$this->note_id = BugNote::get_mantis_id_from_url($url);
	}

	static function get_url_from_mantis_id($id)
	{
		/**
		 * 	Given a Mantis bugnote ID, returns the URL of its resource.
		 */
		return $GLOBALS['cfg_api_url'] . "/notes/$id";
	}

	static function get_mantis_id_from_url($url)
	{
		/**
		 * 	Given the URL of a bugnote, return that note's Mantis ID.
		 */
		$matches = array();
		if (preg_match('!/(\d+)/?$!', $url, &$matches)) {
			return (int)$matches[1];
		} else {
			http_error(404, "No resource at $url");
		}
	}

	static function get_db_row_from_resource($rsrc)
	{
		/**
		 * 	Given a resource (as an array), return the database row.
		 */
		$row = array();
		$row['bug_id'] = Bug::get_mantis_id_from_url($rsrc['bug']);
		$row['reporter_id'] = User::get_mantis_id_from_url($rsrc['reporter']);
		$row['note'] = $rsrc['note'];
		$row['private'] = !!($rsrc['view_state'] == VS_PRIVATE);
		$row['date_submitted'] = $rsrc['date_submitted'];
		$row['last_modified'] = $rsrc['last_modified'];
		return $row;
	}

	static function get_resource_from_db_row($row)
	{
		$rsrc = array();
		$rsrc['bug'] = Bug::get_url_from_mantis_id($row['bug_id']);
		$rsrc['reporter'] = User::get_url_from_mantis_id($row['reporter_id']);
		$rsrc['note'] = $row['note'];
		$rsrc['view_state'] = $row['private'] ? VS_PRIVATE : VS_PUBLIC;
		$rsrc['date_submitted'] = $row['date_submitted'];
		$rsrc['last_modified'] = $row['last_modified'];
		return $rsrc;
	}

	public function get()
	{
		/**
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

		$this->data = BugNote::get_resource_from_db_row($cols);
		return $this->repr();
	}

	public function put()
	{
		if (!bugnote_exists($this->note_id)) {
			http_error(404, "No such bug note: $this->note_id");
		}
		# Check if the current user is allowed to edit the bugnote
		# (This comes from Mantis's bugnote_update.php)
		$user_id = auth_get_current_user_id();
		$reporter_id = bugnote_get_field( $f_bugnote_id, 'reporter_id' );
		if ( ( $user_id != $reporter_id ) ||
				( OFF == config_get( 'bugnote_allow_user_edit_delete' ) )) {
			access_ensure_bugnote_level(
				config_get( 'update_bugnote_threshold' ), $f_bugnote_id );
		}

		# Check if the bug is readonly
		$bug_id = bugnote_get_field( $bugnote_id, 'bug_id' );
		if (bug_is_readonly($bug_id)) {
			http_error(403, "Access denied: bug is read-only.");
		}

		$new_rep = file_get_contents('php://input');
		$new_data = json_decode($new_rep, true);
		$bugnote_data = BugNote::get_db_row_from_resource($new_data);
		bugnote_set_text($this->note_id, $bugnote_data->note);
	}
}
?>
