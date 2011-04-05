<?php
namespace library\myFW;

class App
{
	static function addRoute($re, $c = "index", $m = "index")
	{
		self::$routes[] = array($re,$c,$m);
	}
	
	static function run($server, $key = "thinphp")
	{	
		Exception::registerHandler();

		$environment = new Environment($server);
		$request = new Request($environment);
		return $request->run();
	}
}
