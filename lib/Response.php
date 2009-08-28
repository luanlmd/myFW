<?php
class Response
{
	static function redirect($url = "", $external = false)
	{
		if ($external)
		{
			header("Location: ". new Link($url));
			die();
		}
		header("Location: ".App::$virtualRoot.$url);
		die();
	}
}
