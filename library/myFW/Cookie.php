<?php
namespace library\myFW;

class Cookie 
{
	private static function generateName($name)
	{
		return md5(Crypt::encrypt($name,App::$projectId));
	} 
	public static function set ($name, $value, $lifetime = 172800, $domain = null)
	{
		$lifetime = time() + $lifetime;
		$name = self::generateName($name);
		$value = Crypt::encrypt($value,App::$projectId.$name);
		setcookie($name, $value, $lifetime, $domain);
		return $value;
	}

	public static function del($name)
	{
		self::set($name, null);
	}

	public static function get ($name)
	{
		$name = self::generateName($name);
		return $_COOKIE[$name];
		return (isset($_COOKIE[$name])? Crypt::decrypt($_COOKIE[$name],App::$projectId.$name) : null);
	}
}
