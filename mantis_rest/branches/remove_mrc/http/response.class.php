<?php
class Response
{
	/**
	 * 	An HTTP response.
	 *
	 * 	Headers are stored and sent at the same time as the body.
	 */
	function __construct()
	{
		$this->status = 200;
		$this->headers = array();
		$this->body = "";
		$this->entity_content_type = "text/x-json";
	}

	public function send()
	{
		/**
		 * 	Sends off the response.
		 */
		header("HTTP/1.1 $this->status");
		foreach ($this->headers as $h) {
			header($h);
		}
		if (!empty($this->body)) {
			header("Content-type: $this->entity_content_type");
			echo $this->body;
		}
	}
}
