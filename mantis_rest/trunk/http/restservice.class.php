<?php
class RestService
{
	/**
	 * 	Our REST service.
	 */
	public function handle($request)
	{
		/**
		 * 	Handles the resource request.
		 *
		 * 	@param $request - A Request object
		 * 	@param $return_response - If given, we return the Response object
		 * 		instead of sending it.
		 */
		if (!auth_attempt_script_login($request->username, $request->password)) {
			throw new HTTPException(401, "Invalid credentials", array(
				'WWW-Authenticate: Basic realm="Mantis REST API"'));
		}

		$path = $request->rsrc_path;
		if (preg_match('!^/users/?$!', $path)) {
			$resource = new UserList();
		} elseif (preg_match('!^/users/\d+/?$!', $path)) {
			$resource = new User();
		} elseif (preg_match('!^/bugs/?$!', $path)) {
			$resource = new BugList();
		} elseif (preg_match('!^/bugs/\d+/?$!', $path)) {
			$resource = new Bug();
		} elseif (preg_match('!^/bugs/\d+/notes/?$!', $path)) {
			$resource = new BugnoteList($request->url);
		} elseif (preg_match('!^/notes/\d+/?$!', $path)) {
			$resource = new Bugnote();
		} else {
			throw new HTTPException(404, "No resource at this URL");
		}

		if ($request->method == 'GET') {
			$resp = $resource->get($request);
		} elseif ($request->method == 'PUT') {
			$resp = $resource->put($request);
		} elseif ($request->method == 'POST') {
			$resp = $resource->post($request);
		} else {
			throw new HTTPException(501, "Unrecognized method: $request->method");
		}

		return $resp;
	}
}
