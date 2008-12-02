<?php

require_once 'test/testdb.class.php';

require_once 'test/resources/alltests.class.php';

class AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite();
		$suite->addTest(resources_AllTests::suite());
		return $suite;
	}
}
