<?php
class resources_BugnoteTest extends PHPUnit_Framework_TestCase
{
	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a Bugnote.
		 */
		$request = new Request();
		$request->populate($url='http://mantis.localhost/rest/notes/1', $method='GET',
			$username='dan', $password='dan');

		$service = new RestService;
		$resp = $service->handle($request, TRUE);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->headers, array());
		$this->assertEquals($resp->body, '{"bug":"http:\/\/mantis.localhost\/rest\/bugs\/1","reporter":"http:\/\/mantis.localhost\/rest\/users\/2","note":"Ring ring","private":false,"date_submitted":"2008-10-08T22:47:42-04:00","last_modified":"2008-11-18T22:39:12-05:00"}');
	}

	public function testGetAccessDenialByProject()
	{
		/**
		 * 	Tests that access is denied correctly.
		 */
		$request = new Request();
		$request->populate($url='http://mantis.localhost/rest/notes/7', $method='GET',
			$username='nobody', $password='nobody');

		$service = new RestService;
		try {
			$resp = $service->handle($request, TRUE);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			$this->assertEquals($e->resp->headers, array());
		}
	}

#	public function test_put() {}
#	public function test_put_access() {}

#	public function testCrap() { $this->assertEquals(1, 4); }
}
