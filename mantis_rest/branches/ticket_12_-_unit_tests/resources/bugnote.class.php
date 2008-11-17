<?php
class Bugnote extends Resource
{
	/**
	 *      A bug note.
	 */
	public static $mantis_attrs = array('bug_id', 'reporter_id', 'note', 'view_state',
					    'date_submitted', 'last_modified');
	public static $rsrc_attrs = array('bug', 'reporter', 'note', 'private', 'date_submitted',
	       				  'last_modified');

	static function get_url_from_mantis_id($id)
	{
		/**
		 * 	Given a Mantis bugnote ID, returns the URL of its resource.
		 */
		return $GLOBALS['cfg_api_url'] . "/notes/$id";
	}

	static function get_mantis_id_from_url($url)
	{
		$matches = array();
		if (preg_match('!/(\d+)/?$!', $url, &$matches)) {
			return (int)$matches[1];
		} else {
			http_error(404, "No resource at $url");
		}
	}

	function __construct($url)
	{
		/**
		 *      Constructs the note.
		 *
		 *      @param $url - The URL with which this resource was requested
		 */
		$matches = array();
		$this->note_id = Bugnote::get_mantis_id_from_url($url);

		$this->mantis_data = array();
		$this->rsrc_data = array();
	}

	private function _get_rsrc_attr($attr_name)
	{
		if ($attr_name == 'bug') {
			return Bug::get_url_from_mantis_id($this->mantis_data['bug_id']);
		} elseif ($attr_name == 'reporter') {
			return User::get_url_from_mantis_id($this->mantis_data['reporter_id']);
		} elseif ($attr_name == 'private') {
			return ($this->mantis_data['view_state'] == VS_PRIVATE);
		} elseif ($attr_name == 'date_submitted' || $attr_name == 'last_modified') {
			return date_to_iso_date($this->mantis_data[$attr_name]);
		} elseif (in_array($attr_name, Bugnote::$rsrc_attrs)) {
			return $this->mantis_data[$attr_name];
		} else {
			http_error(415, "Unknown resource attribute: $attr_name");
		}
	}

	private function _get_mantis_attr($attr_name)
	{
		if ($attr_name == 'bug_id') {
			return Bug::get_mantis_id_from_url($this->rsrc_data['bug']);
		} elseif ($attr_name == 'reporter_id') {
			return User::get_mantis_id_from_url($this->rsrc_data['reporter']);
		} elseif ($attr_name == 'view_state') {
			return ($this->rsrc_data['private'] ? VS_PRIVATE : VS_PUBLIC);
		} elseif (in_array($attr_name, Bugnote::$mantis_attrs)) {
			return $this->rsrc_data[$attr_name];
		}
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
		for ($i = 0; $i < count($col_names); $i++) {
			$this->mantis_data[$col_names[$i]] = $row[$i];
		}
		foreach (Bugnote::$rsrc_attrs as $a) {
			$this->rsrc_data[$a] = $this->_get_rsrc_attr($a);
		}
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
		$reporter_id = bugnote_get_field($this->note_id, 'reporter_id');
		$bug_id = bugnote_get_field( $this->note_id, 'bug_id' );
		if (( $user_id != $reporter_id ) ||
				(OFF == config_get('bugnote_allow_user_edit_delete'))) {
			if (!access_has_bugnote_level(
					config_get('update_bugnote_threshold'), $this->note_id)) {
				http_error(403, "Access denied");
			}
		}

		# Check if the bug is readonly
		if (bug_is_readonly($bug_id)) {
			http_error(403, "Access denied: bug is read-only.");
		}

		$new_rep = file_get_contents('php://input');
		$new_data = json_decode($new_rep, true);
		$this->rsrc_data = $new_data;
		bugnote_set_text($this->note_id, $this->_get_mantis_attr('note'));
	}
}
?>
