<?php

define('TABLE_PREFIX', 'mantisrest_test');
define('DB_DUMP_FILE', 'test/test_db_dump.sql');
define('DB_UNDUMP_FILE', 'test/test_db_undump.sql');

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
		$this->db_host = config_get('hostname');
		$this->db_type = config_get('db_type');
		$this->db_name = config_get('database_name');
		$this->db_user = config_get('db_username');
		$this->db_pass = config_get('db_password');
	}

	public function populate()
	{
		/**
		 * 	Fills the test database with predefined inputs.
		 *
		 * 	The data comes from DB_DUMP_FILE.
		 */
		system("mysql -u$this->db_user -p$this->db_pass $this->db_name < " . DB_DUMP_FILE);
	}

	public function unpopulate()
	{
		/**
		 * 	Gets rid of the test tables.
		 */
		system("mysql -u$this->db_user -p$this->db_pass $this->db_name < " . DB_UNDUMP_FILE);
	}
}
