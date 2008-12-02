<?php
require_once 'test/resourcetest.abstract.php';

class resources_BugListTest extends ResourceTest
{
	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a BugList.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->entity_content_type, 'text/x-json');

		$rsrc = json_decode($resp->body, TRUE);
		sort($rsrc['results']);
		$expected_rsrc = array("results" =>
			array("http://mantis.localhost/rest/bugs/1","http://mantis.localhost/rest/bugs/2","http://mantis.localhost/rest/bugs/5"));
		sort($expected_rsrc['results']);
		$this->assertEquals($rsrc, $expected_rsrc);
	}

	public function testGetAccessDenial()
	{
		/**
		 * 	Tests that access is denied correctly by bugnote view state.
		 *
		 * 	If a user doesn't have permission to view some bugs, because they're
		 * 	private or belong to a restricted project, they shouldn't appear on the
		 * 	list.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs',
			'GET',
			'nobody',
			'nobody');

		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/bugs\/1"]}');
	}

	public function testGetFilteringByQuerystring()
	{
		/**
		 * 	Tests that filtering the result by query-string works correctly.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs?priority=urgent&reporter=http:%2F%2Fmantis.localhost%2Frest%2Fusers%2F2',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/bugs\/1"]}');
	}

	public function testGetSortingByQuerystring()
	{
		/**
		 * 	Tests that sorting the result by query string works.
		 */

		# Sort by priority descending.
		$this->request->populate('http://mantis.localhost/rest/bugs?sort-priority=-1',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/bugs\/2","http:\/\/mantis.localhost\/rest\/bugs\/1","http:\/\/mantis.localhost\/rest\/bugs\/5"]}');

		# Sort by reporter asending.
		$this->request->populate('http://mantis.localhost/rest/bugs?sort-reporter',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$new_rsrc = json_decode($resp->body, TRUE);
		$this->assertEquals(count($new_rsrc['results']), 3);
		$this->assertEquals($new_rsrc['results'][2], 'http://mantis.localhost/rest/bugs/5');
	}

	public function testGetSortingByInvalidAttr()
	{
		/**
		 * 	Tests that sorting by an unknown attribute fails.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs?sort-fhgwhgds=-1',
			'GET',
			'dan',
			'dan');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 500);
			return;
		}

		$this->fail('No exception when sort should have failed');
	}

	public function testPostBasic()
	{
		/**
		 * 	Tests a basic POST.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs',
			'POST',
			'somebody',
			'somebody',
			$body='{"project_id":1,"reporter":"http:\/\/mantis.localhost\/rest\/users\/3","handler":"","duplicate":"","priority":"low","severity":"major","reproducibility":"have not tried","status":"new","resolution":"open","projection":"none","category":"","date_submitted":"2008-10-08T21:42:56-04:00","last_updated":"2008-11-22T22:14:20-05:00","eta":"none","os":"","os_build":"","platform":"","version":"","fixed_in_version":"","target_version":"","build":"","private":false,"summary":"Let\'s hope this bug gets posted","profile_id":0,"description":"Post it post it post it","steps_to_reproduce":"","additional_information":""}');
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
		$this->assertEquals($new_note['reporter'], 'http://mantis.localhost/rest/users/3');
		$this->assertEquals($new_note['description'], 'Post it post it post it');
	}

	public function testPostAccessDenial()
	{
		/**
		 * 	Tests that users who shouldn't be able to post a note on a bug can't.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs',
			'POST',
			'nobody',
			'nobody',
			$body='{"project_id":2,"reporter":"http:\/\/mantis.localhost\/rest\/users\/3","handler":"","duplicate":"","priority":"low","severity":"major","reproducibility":"have not tried","status":"new","resolution":"open","projection":"none","category":"","date_submitted":"2008-10-08T21:42:56-04:00","last_updated":"2008-11-22T22:14:20-05:00","eta":"none","os":"","os_build":"","platform":"","version":"","fixed_in_version":"","target_version":"","build":"","private":false,"summary":"Let\'s hope this bug gets posted","profile_id":0,"description":"Post it post it post it","steps_to_reproduce":"","additional_information":""}');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}
}
