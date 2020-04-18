<?php

class Response {
	
	protected $headers = array();
	
	protected $body;
	
	protected $sent = false;
	
	private $status = 200;
	
	private $codes = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',

		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported',

		226 => 'IM Used',

		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '(Unused)',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',

		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Payload Too Large',
		414 => 'URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Range Not Satisfiable',
		417 => 'Expectation Failed',

		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',

		426 => 'Upgrade Required',

		428 => 'Precondition Required',
		429 => 'Too Many Requests',

		431 => 'Request Header Fields Too Large',

		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',

		510 => 'Not Extended',
		511 => 'Network Authentication Required'
	    );
    
    
	/**
	* Add / update the header with the value
	*/ 
	public function header($header, $value) {
		$this->headers[$header] = $value;
	}
	
	/**
	 * 	Set the status
	 */ 
	public function status($status) {		
		$this->status = $status;
	}
    
	/**
	* 	Set the body = data
	*/ 
	public function write($data = ""){
		$this->body = $data;
	}
	
	/**
	 * Set body = json and Content-Type to application/json
	 */
	public function json($json) {
		$this->headers["Content-Type"] = "application/json";
		
		$this->write(json_encode($json));
		
		$this->send();
	}
	
	/**
	* Gets the content length.
	*
	* @return string Content length
	*/
	public function getContentLength() {
		return strlen($this->body);
	}
	
	/**
	 * 	Send the headers
	 */
	public function sendHeaders () {
		header(
			sprintf(
				'Status: %d %s',
				$this->status,
				$this->codes[$this->status]
			),
		    true
		);
        
		foreach ($this->headers as $field => $value) {
		    if (is_array($value)) {
			foreach ($value as $v) {
			    header($field.': '.$v, false);
			}
		    }
		    else {
			header($field.': '.$value);
		    }
		}
        
		// Send content length
		$length = $this->getContentLength();

		if ($length > 0) {
		    header('Content-Length: '.$length);
		}
	}
	
	/**
	 * 	Send the response to client
	 */ 
	public function send(){
		if (ob_get_length() > 0) {
		    ob_end_clean();
		}
        
		if(!$this->sent && !headers_sent()){
			$this->sendHeaders();
		}
		
		echo $this->body;
		
		$this->sent = true;
	}
}
