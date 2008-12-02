<?php
require_once 'test/resourcetest.abstract.php';

class resources_UserListTest extends ResourceTest
{
	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a UserList.
		 */
		$this->request->populate('http://mantis.localhost/rest/users',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->entity_content_type, 'text/x-json');

		$rsrc = json_decode($resp->body, TRUE);
		sort($rsrc['results']);
		$expected_rsrc = array("results" =>
			array("http://mantis.localhost/rest/users/1",
				"http://mantis.localhost/rest/users/2",
				"http://mantis.localhost/rest/users/3",
				"http://mantis.localhost/rest/users/4"));
		$this->assertEquals($rsrc, $expected_rsrc);
	}

	public function testGetAccessDenial()
	{
		/**
		 * 	Tests that access is denied correctly.
		 */
		$this->request->populate('http://mantis.localhost/rest/users',
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

	public function testGetFilteringByQuerystring()
	{
		/**
		 * 	Tests that filtering the result by query-string works correctly.
		 */
		$this->request->populate('http://mantis.localhost/rest/users?username=somebody',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/users\/4"]}');

		$this->request->populate('http://mantis.localhost/rest/users?access_level=administrator',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/users\/1","http:\/\/mantis.localhost\/rest\/users\/2"]}');
	}

	public function testGetSortingByQuerystring()
	{
		/**
		 * 	Tests that sorting a result with a quesry string works.
		 */
		$this->request->populate('http://mantis.localhost/rest/users?sort-access_level&sort-username=-1',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/users\/3","http:\/\/mantis.localhost\/rest\/users\/4","http:\/\/mantis.localhost\/rest\/users\/2","http:\/\/mantis.localhost\/rest\/users\/1"]}');
	}

	public function testPostBasic()
	{
		/**
		 * 	Tests a basic POST.
		 */
		$this->request->populate('http://mantis.localhost/rest/users',
			'POST',
			'dan',
			'dan',
			'{"username":"lalala","password":"secret","realname":"bah","email":"devnull@localhost","date_created":"2008-10-04T22:56:53-04:00","last_visit":"2008-11-23T11:19:11-05:00","enabled":true,"protected":false,"access_level":"developer","login_count":0,"lost_password_request_count":0,"failed_login_count":0}');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 201);
		foreach ($resp->headers as $h) {
			if (strpos($h, 'location: ') == 0) {
				$location = substr($h, strlen('location: '));
			}
		}
		$this->assertEquals($location, json_decode($resp->body, TRUE),
			"Location header doesn't match URL in body");

		$this->request->populate($location,
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$new_note = json_decode($resp->body, TRUE);
		$this->assertEquals($new_note['username'], 'lalala');
		$this->assertEquals($new_note['realname'], 'bah');
	}

	public function testPostAccessDenial()
	{
		/**
		 * 	Tests that users who shouldn't be able to create a user can't.
		 */
		$this->request->populate('http://mantis.localhost/rest/users',
			'POST',
			'nobody',
			'nobody',
			'{"username":"lalala","password":"secret","realname":"bah","email":"devnull@localhost","date_created":"2008-10-04T22:56:53-04:00","last_visit":"2008-11-23T11:19:11-05:00","enabled":true,"protected":false,"access_level":"developer","login_count":0,"lost_password_request_count":0,"failed_login_count":0}');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}
}
