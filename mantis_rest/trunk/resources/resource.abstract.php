<?php
abstract class Resource
{
	/**
	 * 	A REST resource; the abstract for all resources we serve.
	 *
	 * 	This is the abstract for a ''singular'' resource, like a Bug or a User or a
	 * 	Project.  Resource lists have different needs and thus a different abstract
	 * 	(ResourceList).
	 */
	abstract public static function get_url_from_mantis_id($id);
	abstract public static function get_mantis_id_from_url($url);

	protected function _repr($request)
	{
		/**
		 * 	Returns a representation of resource.
		 *
		 * 	@param $request - The request we're answering
		 */
		$type = $request->type_expected;
		if ($type == 'text/x-json' || $type == 'application/json') {
			return json_encode($this->rsrc_data);
		} else {
			throw new HTTPException(406, "Unsupported content type: '$type'");
		}
	}

	public function post($request)
	{
		method_not_allowed('POST', array('GET', 'PUT'));
	}


	/**
	 * 	Returns the value that a given Mantis attribute should have, based on resource
	 * 	data.
	 */
	abstract protected function _get_mantis_attr($attr_name);

	/**
	 * 	Returns the value that a given resource attribute should have, based on Mantis
	 * 	data.
	 */
	abstract protected function _get_rsrc_attr($attr_name);


	/**
	 * 	Handles a GET request for the resource, returning a Response object.
	 */
	abstract public function get($request);

	/**
	 * 	Handles a PUT request for the resource, returning a Response object.
	 */
	abstract public function put($request);

	/**
	 * 	Fills the Resource's data arrays based on what's in the Mantis database.
	 */
	abstract public function populate_from_db();
	
	/**
	 * 	Fills the Resource's data arrays based on a provided representation.
	 *
	 * 	Should throw a 500 if not all the rsrc_attrs are present in the decoded array.
	 */
	abstract public function populate_from_repr($repr);
}
