<?php
class resources_BugTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->request = new Request();
		$this->service = new RestService();
	}

	public function tearDown()
	{
		unset($this->request);
		unset($this->service);
	}

	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a Bug.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/1',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->headers, array());
		$this->assertEquals($resp->body, '{"project_id":1,"reporter":"http:\/\/mantis.localhost\/rest\/users\/2","handler":"http:\/\/mantis.localhost\/rest\/users\/4","duplicate":"","priority":"urgent","severity":"feature","reproducibility":"always","status":"acknowledged","resolution":"open","projection":"tweak","category":"","date_submitted":"2008-09-30T22:27:33-04:00","last_updated":"2008-11-22T22:15:04-05:00","eta":"< 1 week","os":"","os_build":"","platform":"","version":"","fixed_in_version":"","target_version":"","build":"","private":false,"summary":"Swizzle","profile_id":0,"description":"I has a description","steps_to_reproduce":"","additional_information":"Oh noes!  A bug!"}');
	}

	public function testGetAccessDenialByProject()
	{
		/**
		 * 	Tests that access is denied correctly by project.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/2',
			'GET',
			'nobody',
			'nobody');

		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when access should have been denied');
	}

	public function testGetAccessDenialByViewstate()
	{
		/**
		 * 	Tests that access is denied correctly by bug view state.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/5',
			'GET',
			'nobody',
			'nobody');

		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}

	public function testPutBasic()
	{
		/**
		 * 	Tests a basic PUT.
		 *
		 * 	We change the handler, status, and summary fields.  We also make sure that
		 * 	`last_updated` changes.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/5',
			'PUT',
			'dan',
			'dan',
			$body='{"project_id":1,"reporter":"http:\/\/mantis.localhost\/rest\/users\/2","handler":"http:\/\/mantis.localhost\/rest\/users\/3","duplicate":"","priority":"urgent","severity":"feature","reproducibility":"always","status":"feedback","resolution":"open","projection":"tweak","category":"","date_submitted":"2008-09-30T22:27:33-04:00","last_updated":"2008-11-22T22:15:04-05:00","eta":"< 1 week","os":"","os_build":"","platform":"","version":"","fixed_in_version":"","target_version":"","build":"","private":false,"summary":"Changed this bug","profile_id":0,"description":"I\'m in ur database, alterin ur descriptionz","steps_to_reproduce":"","additional_information":""}');
		try {
		$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			echo $e->resp->body."\n";
		}
		$this->assertEquals($resp->status, 204);
		$this->assertEquals($resp->body, '');

		$this->request->populate('http://mantis.localhost/rest/bugs/5',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$new_bug = json_decode($resp->body, TRUE);
		$this->assertEquals($new_bug['handler'], 'http://mantis.localhost/rest/users/3');
		$this->assertEquals($new_bug['status'], 'feedback');
		$this->assertEquals($new_bug['summary'], 'Changed this bug');
		$this->assertEquals($new_bug['description'],
			'I\'m in ur database, alterin ur descriptionz');
		$this->assertTrue($new_bug['last_updated'] > '2008-11-22T22:15:04-05:00');
	}

	public function testPutAccessDenial()
	{
		/**
		 * 	Tests that users who shouldn't be able to edit a bug can't.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/1',
			'PUT',
			'nobody',
			'nobody',
			$body='{"project_id":1,"reporter":"http:\/\/mantis.localhost\/rest\/users\/2","handler":"http:\/\/mantis.localhost\/rest\/users\/3","duplicate":"","priority":"urgent","severity":"feature","reproducibility":"always","status":"feedback","resolution":"open","projection":"tweak","category":"","date_submitted":"2008-09-30T22:27:33-04:00","last_updated":"2008-11-22T22:15:04-05:00","eta":"< 1 week","os":"","os_build":"","platform":"","version":"","fixed_in_version":"","target_version":"","build":"","private":false,"summary":"Changed this bug","profile_id":0,"description":"I\'m in ur database, alterin ur descriptionz","steps_to_reproduce":"","additional_information":""}');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}
}
