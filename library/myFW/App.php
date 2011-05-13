<?php
namespace myFW;

class App
{
	static $key;
	static $routes = array();

	static function addRoute($re, $controller = "index", $action = "index", $path = '')
	{
		self::$routes[] = array($re,$controller,$action, $path);
	}
	
	static function run($server, $key = "myFW")
	{	
		self::$key = $key;
		$environment = new Environment($server);
		$request = new Request($environment);
		return $request->run();
	}
}
