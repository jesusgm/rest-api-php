<?php

class Route {
	public $methods;
	public $patern;
	public $params;
	public $callback;
	
	public function __construct($methods = "GET", $pattern, $callback)
	{
		$this->methods = explode(' ', $methods);
		$this->pattern = $pattern;
		$this->callback = $callback;
		$this->params = array();
	}
	
	/**
	 * Checks if the route match with method and the url
	 * 
	 * @returns Boolean
	 */
	public function match($method, $url) {
		
		// The method not match
		if (in_array($method, $this->methods) === false) {
			return false;
		}
		
		// Wildcard or exact match
		if ($this->pattern === '*' || $this->pattern === $url) {
			return true;
		}		

		$patternTokens = explode('/', $this->pattern);
		$urlTokens = explode('/', $url);
		
		if(count($patternTokens) != count($urlTokens)) {
			return false;
		}
		
		$found = false;
		foreach($patternTokens as $key => $ptoken) {
			
			if($ptoken == $urlTokens[$key] || strpos($ptoken, '@') !== false) {
				
				if(strpos($ptoken, '@') !== false){
					$this->params[str_replace('@', '' , $ptoken)] = $urlTokens[$key];	
					$found = true;
				}
			} else {
				$found = false;
			}
		}
		

		return $found;
	}
}
