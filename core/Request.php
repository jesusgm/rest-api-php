<?php
	
	class Request {
		private $ip;
		private $url;
		private $base;
		private $method;
		private $userAgent;
		private $queryParameters;
		private $files;
		private $type;
		private $cookies;
		private $body;
		
		public function __construct($params) {
			$this->ip = $this->getVar('REMOTE_ADDR');
			$this->url = str_replace('@', '%40', $this->getVar('REQUEST_URI', '/'));
			$this->base = str_replace(array('\\',' '), array('/','%20'), dirname($this->getVar('SCRIPT_NAME')));
			$this->method = $this->getMethod();
			$this->userAgent = $this->getVar('HTTP_USER_AGENT');
			$this->queryParameters = array_merge($_GET, $params);
			$this->files = $_FILES;
			$this->type = $this->getVar('CONTENT_TYPE');
			$this->cookies = $_COOKIE;
			$this->body = $this->getBody();
			
		}	
		
		/**
		 *	Get the var of $_SERVER array
		 * 
		 * @return string of key param or default valur param 
		 */
		public function getVar($key, $default = '') {
			return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
		}
		
		public function getMethod() {
			return $this->getVar('REQUEST_METHOD', 'GET');
		}
		
		/**
		 * Gets the body of the request.
		 *
		 * @return string Raw HTTP request body
		 */
		public function getBody() {
			$method = $this->getMethod();

			if ($method == 'POST' || $method == 'PUT' || $method == 'DELETE' || $method == 'PATCH') {
				return file_get_contents('php://input');
			}

			return "";
		}	
		
		/**
		 * Get query parameters array
		 */
		public function getParams() {
			return $this->queryParameters;
		} 
		
		
	}
