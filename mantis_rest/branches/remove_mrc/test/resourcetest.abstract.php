<?php
abstract class ResourceTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->request = new Request();
		$this->service = new RestService();

		$test_db = new TestDB();
		$test_db->populate();

		global $g_db_table_prefix;
		$this->old_db_table_prefix = $g_db_table_prefix;
		$g_db_table_prefix = $test_db->table_prefix;
	}

	public function tearDown()
	{
		unset($this->request);
		unset($this->service);

		global $db_table_prefix;
		$db_table_prefix = $this->old_db_table_prefix;
	}
}
