<?php
function method_not_allowed($method, $allowed)
{
	/**
	 * 	Errors out when a method is not allowed on a resource.
	 *
	 * 	We set the Allow header, which is a MUST according to RFC 2616.
	 *
	 * 	@param $method - The method that's not allowed
	 * 	@param $allowed - An array containing the methods that are allowed
	 */
	throw new HTTPException(405, "The method $method can't be used on this resource",
		array("allow: " . implode(", ", $allowed)));
}

function get_string_to_enum($enum_string, $string)
{
	/**
	 * 	Gets Mantis's integer for the given string
	 *
	 * 	This is the inverse of Mantis's get_enum_to_string().  If the string is
	 * 	not found in the enum string, we return -1.
	 */
	if (preg_match('/^@.*@$/', $string)) {
		return substr($string, 1, -1);
	}
	$enum_array = explode_enum_string($enum_string);
	foreach ($enum_array as $pair) {
		$t_s = explode_enum_arr($pair);
		if ($t_s[1] == $string) {
			return $t_s[0];
		}
	}
	return -1;
}

function date_to_timestamp($iso_date)
{
	/**
	 *	Returns a UNIX timestamp for the given date.
	 *
	 *	@param $iso_date - A string containing a date in ISO 8601 format
	 */
	return strtotime($iso_date);
}

function timestamp_to_iso_date($timestamp)
{
	/**
	 *	Returns an ISO 8601 date for the given timestamp.
	 *
	 *	@param $timestamp - The timestamp.
	 */
	return date('c', $timestamp);
}

function date_to_iso_date($date)
{
	return date('c', strtotime($date));
}

function date_to_sql_date($date)
{
	return date('Y-m-d H:i:s', strtotime($date));
}
