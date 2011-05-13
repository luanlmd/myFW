<?php
namespace myFW;

class Config
{
	static function get($section, $key)
	{
		$config = parse_ini_file('../config.ini', true);
		if (isset($config[$section][$key]))
		{
			return $config[$section][$key];
		}
		throw new \Exception("Couldn't find Section {$section} and Key {$key} in config file");
	}
}
