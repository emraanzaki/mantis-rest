<?php
require_once 'test/resourcetest.abstract.php';

class resources_BugnoteListTest extends ResourceTest
{
	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a BugnoteList.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/1/notes',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->headers, array());
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/notes\/1","http:\/\/mantis.localhost\/rest\/notes\/6","http:\/\/mantis.localhost\/rest\/notes\/8","http:\/\/mantis.localhost\/rest\/notes\/10"]}');
	}

	public function testGetAccessDenialByBug()
	{
		/**
		 * 	Tests that access is denied correctly by bug (i.e. by project).
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/2/notes',
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
		 * 	Tests that access is denied correctly by bugnote view state.
		 *
		 * 	If a user doesn't have permission to view some of the notes on a bug,
		 * 	because they're private, they shouldn't appear on the list.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/1/notes',
			'GET',
			'nobody',
			'nobody');

		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/notes\/1","http:\/\/mantis.localhost\/rest\/notes\/6","http:\/\/mantis.localhost\/rest\/notes\/10"]}');
	}

	public function testGetFilteringByQuerystring()
	{
		/**
		 * 	Tests that filtering result by query-string works correctly.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/1/notes?reporter=http:%2F%2Fmantis.localhost%2Frest%2Fusers%2F4',
			'GET',
			'dan',
			'dan');

		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/notes\/10"]}');
	}

	public function testGetSortingByQuerystring()
	{
		/**
		 * 	Tests that sorting result by query-string works correctly.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/1/notes?sort-last_modified=-1',
			'GET',
			'dan',
			'dan');

		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->body, '{"results":["http:\/\/mantis.localhost\/rest\/notes\/10","http:\/\/mantis.localhost\/rest\/notes\/1","http:\/\/mantis.localhost\/rest\/notes\/8","http:\/\/mantis.localhost\/rest\/notes\/6"]}');
	}

	public function testPost()
	{
		/**
		 * 	Tests a basic POST.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/2/notes',
			'POST',
			'dan',
			'dan',
			$body='{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/2","reporter":"http:\/\/mantis.localhost\/rest\/users\/2","text":"New note.  Check out this note.","private":false,"date_submitted":"2008-11-22T22:15:04-05:00","last_modified":"2008-11-22T22:15:04-05:00"}');
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
		$this->assertEquals($new_note['bug'], 'http://mantis.localhost/rest/bugs/2');
		$this->assertEquals($new_note['text'], 'New note.  Check out this note.');
	}

	public function testPostAccessDenial()
	{
		/**
		 * 	Tests that users who shouldn't be able to post a note on a bug can't.
		 */
		$this->request->populate('http://mantis.localhost/rest/bugs/2/notes',
			'POST',
			'nobody',
			'nobody',
			$body='{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/2","reporter":"http:\/\/mantis.localhost\/rest\/users\/2","text":"We want this note to be denied.","private":true,"date_submitted":"2008-11-22T22:15:04-05:00","last_modified":"2008-11-22T22:15:04-05:00"}');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}
}
