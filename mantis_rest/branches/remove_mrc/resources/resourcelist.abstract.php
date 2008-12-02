<?php
abstract class ResourceList
{
	/**
	 * 	A list of similar REST resources.
	 *
	 * 	This is the kind of resource you'll find at paths like /bugs and /users.
	 */
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

	protected function _build_sql_from_querystring($qs)
	{
		/**
		 * 	Returns a string of SQL to tailor a query to the given query string.
		 *
		 * 	Resource lists use this function to filter, order, and limit their
		 * 	result sets.
		 *
		 * 	@param $qs - The query string
		 */
		$qs_pairs = array();
		parse_str($qs, $qs_pairs);

		$filter_pairs = array();
		$sort_pairs = array();
		$limit = 0;
		foreach ($qs_pairs as $k => $v) {
			if (strpos($k, 'sort-') === 0) {
				$sort_pairs[$k] = $v;
			} elseif ($k == 'limit') {
				$limit = (int)$v;
				if ($limit < 0) {
					$limit = 0;
				}
			} else {
				$filter_pairs[$k] = $v;
			}
		}

		$conditions = array();
		$orders = array();
		$limit_statement = "";
		foreach ($filter_pairs as $k => $v) {
			$condition = $this->_get_query_condition($k, $v);
			if ($condition) {
				$conditions[] = $condition;
			}
		}
		foreach ($sort_pairs as $k => $v) {
			$k = substr($k, 5);	# Strip off the 'sort-'
			$orders[] = $this->_get_query_order($k, $v);
		}
		if ($limit) {
			$limit_statement = "LIMIT $limit";
		}

		$sql = "";
		if ($conditions) {
			$sql .= ' WHERE (';
			$sql .= implode(') AND (', $conditions);
			$sql .= ')';
		}
		if ($orders) {
			$sql .= ' ORDER BY ';
			$sql .= implode(', ', $orders);
		}
		if ($limit) {
			$sql .= " LIMIT $limit";
		}
		return $sql;
	}

	public function put($request)
	{
		method_not_allowed('PUT', array('GET', 'POST'));
	}


	/**
	 * 	Given a query string pair, returns a SQL condition for filtering.
	 *
	 * 	Should throw a 500 if the pair doesn't specify a valid way to sort.
	 */
	abstract protected function _get_query_condition($key, $value);

	/**
	 * 	Given a query string pair, returns an ORDER BY argument to apply to a query.
	 *
	 * 	By "ORDER BY argument" I mean something like "u.username DESC" or "b.last_updated".
	 * 	
	 * 	@param $key - Not actually the key from the query string; it will have had the
	 * 		'sort-' pulled off first.
	 * 	@param $value - 1 means ascending, -1 means descending.  Anything else and we don't
	 * 		specify a direction (which probably means ascending).
	 */
	abstract protected function _get_query_order($key, $value);


	/**
	 * 	Handles a GET request for the resource, returning a Response object.
	 */
	abstract public function get($request);

	/**
	 * 	Handles a POST request for the resource, returning a Response object.
	 */
	abstract public function post($request);
}
