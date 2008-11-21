<?php
class BugnoteList extends Resource
{
	/**
	 *      A list of bug notes.
	 */
	function __construct($url) {
		/*
		 *      Constructs the list.
		 *
		 *      @param $url - The URL with which this resource was requested
		 */
		$matches = array();
		if (preg_match('!/bugs/(\d+)/notes/?$!', $url, &$matches)) {
			$this->bug_id = (int)$matches[1];
		} else {
			http_error(404, "Unknown note list");
		}
	}

	public function get($request)
	{
		/*
		 *      Returns a Response with a representation of the note list.
		 *
		 *      @param $request - The Request we're responding to
		 */
		# Access checking and note gathering is based on Mantis's
		# email_build_visible_bug_data().
		$project_id = bug_get_field($this->bug_id, 'project_id');
		$user_id = auth_get_current_user_id();
		$access_level = user_get_access_level($user_id, $project_id);
		if (!access_has_bug_level(VIEWER, $this->bug_id)) {
			http_error(403, "Access denied");
		}

		$notes = bugnote_get_all_visible_bugnotes($this->bug_id, $access_level,
			user_pref_get_pref($this->user_id, 'bugnote_order'),
			128);
		$note_ids = array();
		foreach ($notes as $n) {
			$note_ids[] = $n->id;
		}

		$this->rsrc_data = array();
		foreach ($note_ids as $n) {
			$config = get_config();
			$this->rsrc_data[] = $config['paths']['api_url'] . "/notes/$n";
		}

		$resp = new Response();
		$resp->status = 200;
		$resp->body = $this->repr();
		return $resp;
	}

	public function put($request)
	{
		method_not_allowed("PUT");
	}

	public function post($request)
	{
		/**
		 * 	Creates a new bugnote.
		 *
		 * 	Sets the location header and returns the main URL of the created resource,
		 * 	as RFC2616 says we SHOULD.
		 *
		 * 	@param $request - The Request we're responding to
		 */
		if (!access_has_bug_level(config_get('add_bugnote_threshold'), $this->bug_id)) {
			http_error(403, "Access denied to add bugnote");
		}
		if (bug_is_readonly($this->bug_id)) {
			http_error(500, "Cannot add a bugnote to a read-only bug");
		}

		$new_note = new Bugnote;
		$new_note->populate_from_repr();
		$bugnote_added = bugnote_add($this->bug_id, $new_note->mantis_data['note'],
			'0:00', $new_note->mantis_data['view_state'] == VS_PRIVATE);
		if ($bugnote_added) {
			$bugnote_added_url = Bugnote::get_url_from_mantis_id($bugnote_added);
			$this->rsrc_data = $bugnote_added_url;

			$resp = new Response();
			$resp->headers[] = "location: $bugnote_added_url";
			$resp->status = 201;
			return $resp;
		} else {
			http_error(500, "Couldn't create bugnote");
		}
	}
}
?>
