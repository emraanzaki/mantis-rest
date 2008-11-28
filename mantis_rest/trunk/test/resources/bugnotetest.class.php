<?php
require_once 'test/resourcetest.class.php';

class resources_BugnoteTest extends ResourceTest
{
	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a Bugnote.
		 */
		$this->request->populate('http://mantis.localhost/rest/notes/1',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->headers, array());
		$this->assertEquals($resp->body, '{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/1","reporter":"http:\/\/mantis.localhost\/rest\/users\/2","text":"Ring ring\n\n","private":false,"date_submitted":"2008-10-08T22:47:42-04:00","last_modified":"2008-11-22T23:55:25-05:00"}');
	}

	public function testGetAccessDenialByProject()
	{
		/**
		 * 	Tests that access is denied correctly by project.
		 */
		$this->request->populate('http://mantis.localhost/rest/notes/7',
			'GET',
			'nobody',
			'nobody');

		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			$this->assertEquals($e->resp->headers, array());
			return;
		}

		$this->fail();
	}

	public function testGetAccessDenialByViewstate()
	{
		/**
		 * 	Tests that access is denied correctly by bugnote view state.
		 */
		$this->request->populate('http://mantis.localhost/rest/notes/8',
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
		 * 	We attempt to change the text and the bug it's attached to.  The former
		 * 	should change, the latter should not.  Also, we make sure that
		 * 	`last_modified` changes.
		 */
		$this->request->populate('http://mantis.localhost/rest/notes/8',
			'PUT',
			'dan',
			'dan',
			$body='{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/2","reporter":"http:\/\/mantis.localhost\/rest\/users\/2","text":"Changed the text in this note.","private":true,"date_submitted":"2008-11-22T22:15:04-05:00","last_modified":"2008-11-22T22:15:04-05:00"}');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 204);
		$this->assertEquals($resp->body, '');

		$this->request->populate('http://mantis.localhost/rest/notes/8',
			'GET',
			'dan',
			'dan');
		$resp = $this->service->handle($this->request);
		$new_note = json_decode($resp->body, TRUE);
		$this->assertEquals($new_note['bug'], 'http://mantis.localhost/rest/bugs/1');
		$this->assertEquals($new_note['text'], 'Changed the text in this note.');
		$this->assertTrue($new_note['last_modified'] > '2008-11-22T22:15:04-05:00');
	}

	public function testPutAccessDenial()
	{
		/**
		 * 	Tests that users who shouldn't be able to edit a note can't.
		 */
		$this->request->populate('http://mantis.localhost/rest/notes/8',
			'PUT',
			'nobody',
			'nobody',
			$body='{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/1","reporter":"http:\/\/mantis.localhost\/rest\/users\/2","text":"Changed the text in this note.","private":true,"date_submitted":"2008-11-22T22:15:04-05:00","last_modified":"2008-11-22T22:15:04-05:00"}');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}
}
