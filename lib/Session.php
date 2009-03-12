<?php
class Session 
{
	public static function set ($name , $value)
	{
		@session_start();
		
		if(isset($_SESSION[md5(App::$projectId)]))
		{
			$arr = json_decode(base64_decode($_SESSION[md5(App::$projectId)]));
			$arr->$name = $value;
		}
		else $arr = array($name => $value);
		$_SESSION[md5(App::$projectId)] = base64_encode(json_encode($arr));
		return $value;
	}

	public static function del($name)
	{
		@session_start();
		self::set($name, null);
	}

	public static function clear ()
	{
		@session_start();
		$_SESSION[md5(App::$projectId)] = null;
	}

	public static function get ($name)
	{
		@session_start();
		$arr = json_decode(base64_decode($_SESSION[md5(App::$projectId)]));
		return isset($arr->$name)? $arr->$name : null;
	}
}
