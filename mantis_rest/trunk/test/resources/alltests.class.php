<?php

require_once 'test/resources/bugtest.class.php';
require_once 'test/resources/buglisttest.class.php';
require_once 'test/resources/bugnotetest.class.php';
require_once 'test/resources/bugnotelisttest.class.php';
require_once 'test/resources/usertest.class.php';

class resources_AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('resources tests');
		$suite->addTestSuite('resources_BugTest');
		$suite->addTestSuite('resources_BugListTest');
		$suite->addTestSuite('resources_BugnoteTest');
		$suite->addTestSuite('resources_BugnoteListTest');
		$suite->addTestSuite('resources_UserTest');
		return $suite;
	}
}
