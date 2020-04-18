<?php

require_once("core/app.php");

$app = new App();

$app->route("GET", "/", function ($req, $res) {
	$res->json("Hello world!");
});

/**
 * Start the app
 */ 
$app->start();
