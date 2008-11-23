<?php

require_once 'test/testdb.class.php';

require_once 'test/resources/alltests.class.php';

class AllTests extends PHPUnit_Framework_TestSuite
{
	public static function suite()
	{
		$suite = new AllTests();
		$suite->addTest(resources_AllTests::suite());
		return $suite;
	}

	function __construct()
	{
		$test_db = new TestDB();
		$test_db->populate();
		
		global $g_db_table_prefix;
		$g_db_table_prefix = 'mantisrest_test';
	}
}
