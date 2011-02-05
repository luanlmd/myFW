<?php
namespace library\ThinPHP;

class Session 
{
	public static function set($name , $value)
	{
		if(isset($_SESSION[md5(App::$projectId)]))
		{
			$arr = unserialize($_SESSION[md5(App::$projectId)]);
			$arr[$name] = $value;
		}
		else $arr = array($name => $value);
		$_SESSION[md5(App::$projectId)] = serialize($arr);
		return $value;
	}

	public static function del($name)
	{
		self::set($name, null);
	}

	public static function clear()
	{
		$_SESSION[md5(App::$projectId)] = null;
	}

	public static function get($name)
	{
		if(!isset($_SESSION[md5(App::$projectId)])) { return null; }
		$arr = unserialize($_SESSION[md5(App::$projectId)]);
		return isset($arr[$name])? $arr[$name] : null;
	}

	public static function getAndDel($name)
	{
		if(!isset($_SESSION[md5(App::$projectId)])) { return null; }
		$arr = unserialize($_SESSION[md5(App::$projectId)]);
		self::set($name, null);
		return isset($arr[$name])? $arr[$name] : null;
	}

	public static function exists($name)
	{
		if(!isset($_SESSION[md5(App::$projectId)])) { return false; }
		$arr = unserialize($_SESSION[md5(App::$projectId)]);
		return isset($arr[$name]);
	}
}
