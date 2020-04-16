<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getAction()
{
	switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			return "get";
		case "POST":
			return "add";
		case "PUT";
			return "update";
		case "DELETE";
			return "delete";
		default:
			return "index";
	}
}


$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : '/';

if ($url == '/') {
	// This is the home page
	// Initiate the index controller
	require_once __DIR__.'/Controllers/IndexController.php';

	$indexController = New IndexController();

	print $indexController->index('');

} else {


	// This is not home page
	// Initiate the appropriate controller
	// and render the required view

	//The first element should be a controller
	$requestedController = $url[0];

	// If a second part is added in the URI, 
	// it should be a method
	//$requestedAction = isset($url[1]) ? $url[1] : 'index';
	$requestedAction = getAction();	

	// The remain parts are considered as 
	// arguments of the method
	$requestedParams = array_slice($url, 1);

	// Check if controller exists. NB: 
	// You have to do that for the model and the view too
	$ctrlPath = __DIR__ . '/Controllers/' . ucfirst($requestedController) . 'Controller.php';



	if (file_exists($ctrlPath)) {
		// require_once __DIR__.'/Models/'.$requestedController.'Model.php';
		require_once __DIR__ . '/Controllers/' . ucfirst($requestedController) . 'Controller.php';
		// require_once __DIR__.'/Views/'.$requestedController.'/'.$requestedAction.'.php';

		// $modelName      = ucfirst($requestedController).'Model';
		$controllerName = ucfirst($requestedController) . 'Controller';
		// $viewName       = ucfirst($requestedController).'View';

		$controllerObj  = new $controllerName();
		// $viewObj        = new $viewName( $controllerObj, new $modelName );

		// If there is a method - Second parameter
		if ($requestedAction != '') {
			print $controllerObj->$requestedAction(isset($url[1]) ? $url[1] : '');
		}
	} else {

		header('HTTP/1.1 404 Not Found');
		die('404 - The file - /Controllers/' . ucfirst($requestedController) . 'Controller.php - not found');
		//require the 404 controller and initiate it
	}
}
