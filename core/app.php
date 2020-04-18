<?php

require_once('Request.php');
require_once('Response.php');
require_once('Route.php');

class App
{
	private $routes;
	
	public function __construct() 
	{
		$this->routes = [];		
	}

	public function route($methods = ["GET"], $patern, $callback)
	{
		$route = new Route($methods, $patern, $callback);
	
		$this->routes[] = $route;
	}

	private function findMatchRoute($method, $path)
	{
		//search in this->routes for the method and route		
		foreach ($this->routes as $key => $route) {
			
			if($route->match($method, $path)){
				return $route;
			}
		}
		return null;
	}

	public function showRoutes()
	{
		foreach ($this->routes as $key => $route) {
			echo $route->type . ' ' . $route->patern . '<br/>';
		}
	}


	public function start()
	{
		$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
		
		
		if($path != "/" && substr($path, strlen($path) - 1, 1) == "/"){
			$path = substr($path, 0, -1);
		}

		$method = $_SERVER['REQUEST_METHOD'];
		
		$matchedRoute = $this->findMatchRoute($method, $path);

		$req = new Request($matchedRoute->params);
		$res = new Response();

		if ($matchedRoute) {
			$callback = $matchedRoute->callback;

			$callback($req, $res);
			
		} else {
			//if not route for this path show 404 not found
			$res->status(404);
			$res->write("Not found!");
			$res->send();	
		}
	}
}
