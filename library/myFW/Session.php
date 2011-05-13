<?php
namespace myFW;

class Session 
{
	public static function set($name , $value)
	{
		@session_start();
		if(isset($_SESSION[md5(App::$key)]))
		{
			$arr = unserialize($_SESSION[md5(App::$key)]);
			$arr[$name] = $value;
		}
		else $arr = array($name => $value);
		$_SESSION[md5(App::$key)] = serialize($arr);
		return $value;
	}

	public static function del($name)
	{
		self::set($name, null);
	}

	public static function clear()
	{
		@session_start();
		$_SESSION[md5(App::$key)] = null;
	}

	public static function get($name)
	{
		@session_start();
		if(!isset($_SESSION[md5(App::$key)])) { return null; }
		$arr = unserialize($_SESSION[md5(App::$key)]);
		return isset($arr[$name])? $arr[$name] : null;
	}

	public static function getAndDel($name)
	{
		$value = self::get($name);
		self::set($name, null);
		return $value;
	}

	public static function exists($name)
	{
		if(!isset($_SESSION[md5(App::$key)])) { return false; }
		$arr = unserialize($_SESSION[md5(App::$key)]);
		return isset($arr[$name]);
	}
}
