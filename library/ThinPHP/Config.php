<?php
namespace library\ThinPHP;

class Config
{
	static $configs = array();

	static function set($key, $value)
	{
		self::$configs[$key] = $value;
	}

	static function get($key)
	{
		return (isset(self::$configs[$key]))? self::$configs[$key] : null;
	}
}
