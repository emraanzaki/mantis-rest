<?php

define('TABLE_PREFIX', 'mantisrest_test');
define('DB_DUMP_FILE', 'test/test_db_dump.sql');

class TestDB
{
	/**
	 * 	The database that we use for the tests.
	 *
	 * 	The contents of this database are predefined, and it contains just enough data to
	 * 	get Mantis to run all the tests.
	 */
	function __construct()
	{
		$this->table_prefix = TABLE_PREFIX;
	}

	public function populate()
	{
		/**
		 * 	Fills the test database with predefined inputs.
		 *
		 * 	The data comes from DB_DUMP_FILE.
		 */
		$db_host = config_get('hostname');
		$db_type = config_get('db_type');
		$db_name = config_get('database_name');
		$db_user = config_get('db_username');
		$db_pass = config_get('db_password');
		system("mysql -u$db_user -p$db_pass $db_name < " . DB_DUMP_FILE);
	}
}
