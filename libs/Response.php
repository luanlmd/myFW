<?php
class Response
{
	static function redirect($uri = "", $external = false)
	{
		if ($external)
		{
			header("Location: ". new Link($uri));
			die();
		}
		header("Location: ".App::$virtualRoot.$uri);
		die();
	}
	
	static function error($message)
	{
		throw new Exception("Not yet implemented");
	}
	
	static function success($message, $uri)
	{
		throw new Exception("Not yet implemented");
	}
}
