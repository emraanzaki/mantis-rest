<?php
require_once 'test/resourcetest.class.php';

class resources_UserTest extends ResourceTest
{
	public function testGetBasic()
	{
		/**
		 * 	Tests a basic GET on a User.
		 */
		$this->request->populate('http://mantis.localhost/rest/users/3',
			'GET',
			'nobody',
			'nobody');
		$resp = $this->service->handle($this->request);

		$this->assertEquals($resp->status, 200);
		$this->assertEquals($resp->headers, array());
		$this->assertEquals($resp->body, '{"username":"nobody","password":"********","realname":"what","email":"dan@localhost","date_created":"2008-10-04T16:20:14-04:00","last_visit":"2008-11-23T16:19:17-05:00","enabled":true,"protected":false,"access_level":"reporter","login_count":0,"lost_password_request_count":0,"failed_login_count":0}');
	}

	public function testGetAccessDenial()
	{
		/**
		 * 	Tests that access is denied correctly.
		 */
		$this->request->populate('http://mantis.localhost/rest/users/1',
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

		$this->fail('No exception when access should have been denied');
	}

	public function testPutBasic()
	{
		/**
		 * 	Tests a basic PUT.
		 *
		 * 	We attempt to change the user's password, realname, and access level.
		 */
		$this->request->populate('http://mantis.localhost/rest/users/4',
			'PUT',
			'dan',
			'dan',
			'{"username":"somebody","password":"newpass","realname":"hey thanks","email":"dan@localhost","date_created":"2008-10-04T16:20:14-04:00","last_visit":"2008-11-23T16:19:17-05:00","enabled":true,"protected":false,"access_level":"viewer","login_count":0,"lost_password_request_count":0,"failed_login_count":0}');
		$resp = $this->service->handle($this->request);
		$this->assertEquals($resp->status, 204);
		$this->assertEquals($resp->body, '');

		$this->request->populate('http://mantis.localhost/rest/users/4',
			'GET',
			'somebody',
			'newpass');
		user_clear_cache();
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			if ($e->resp->status == 401) {
				$this->fail('Failed to change password');
			} else {
				throw $e;
			}
		}
		$new_user = json_decode($resp->body, TRUE);
		$this->assertEquals($new_user['realname'], 'hey thanks');
		$this->assertEquals($new_user['access_level'], 'viewer');
	}

	public function testPutAccessDenial()
	{
		/**
		 * 	Tests that users who shouldn't be able to edit a user can't.
		 */
		$this->request->populate('http://mantis.localhost/rest/notes/8',
			'PUT',
			'nobody',
			'nobody',
			'{"username":"somebody","password":"newpass","realname":"new name","email":"dan@localhost","date_created":"2008-10-04T16:20:14-04:00","last_visit":"2008-11-23T16:19:17-05:00","enabled":true,"protected":false,"access_level":"viewer","login_count":0,"lost_password_request_count":0,"failed_login_count":0}');
		try {
			$resp = $this->service->handle($this->request);
		} catch (HTTPException $e) {
			$this->assertEquals($e->resp->status, 403);
			return;
		}

		$this->fail('No exception when we should have had access denied');
	}
}
