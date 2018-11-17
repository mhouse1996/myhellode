<?php
require __DIR__ . "/../init.php";

if(empty($_SERVER['PATH_INFO']))
{
	header("Location: index.php/index");
}

$pathInfo = $_SERVER['PATH_INFO'];

$routes = [
  '/index' => [
    'controller' => 'userController',
    'method' => 'dashboard'
  ],
	'/login' => [
		'controller' => 'userController',
		'method' => 'login'
	],
	'/logout' => [
		'controller' => 'userController',
		'method' => 'logout'
	],
	'/breaksystem' => [
		'controller' => 'breakController',
		'method' => 'showFreeBreakTickets'
	],
	'/takeBreakTicket' => [
		'controller' => 'breakController',
		'method' => 'takeBreakTicket'
	],
	'/unbreak' => [
		'controller' => 'breakController',
		'method' => 'unbreak'
	]
];

if (isset($routes[$pathInfo])) {
  $route = $routes[$pathInfo];
  $controller = $container->make($route['controller']);
  $method = $route['method'];
  $controller->$method();
}
?>