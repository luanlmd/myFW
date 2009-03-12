<?php
class Request
{
	static private function removeInjection($tmp)
	{
		$tmp = str_ireplace("--", "", $tmp);
		$tmp = str_ireplace("'", "''", $tmp);
		return trim($tmp);
	}

	static function get($v)
	{
		global $_GET;
		if (!isset($_GET[$v]))
			return '';
		return self::removeInjection($_GET[$v]);
	}

	static function post($v)
	{
		global $_POST;
		if (!isset($_POST[$v]))
			return '';
		return self::removeInjection($_POST[$v]);
	}
	
	static function uri()
	{
		$uri = $_SERVER["REQUEST_URI"];
		$root = substr(App::$virtualRoot, 0, -1);
		$uri = str_replace($root,"",$uri);
		return self::removeInjection($uri);
	}

	static function par($index)
	{
		$pieces = split("/",self::uri());
		array_shift($pieces);
		if (is_numeric($index))
		{		
			$array = null;
			foreach($pieces as $piece)
			{
				$par = split(":",$piece);
				if (!strstr($piece,":")) { $array[] = $piece; }
			}
			if ($index < 0)
			{
				$index = count($array) + $index;	
			}
			return (($array)? ((isset($array[$index]))? $array[$index] : null)  : null);
		}
		foreach($pieces as $piece)
		{
			$par = split(":",$piece);
			if ($par[0] == $index) { return $par[1]; }
		}
		return null;
	}
	static function isAjax()
	{
		$headers = getallheaders();
		return isset($headers["X-Requested-With"]);
	}
	static function isPost()
	{
		return ($_SERVER["REQUEST_METHOD"] == "POST");
	}
	static function isGet()
	{
		return !Request::isPost();
	}
}
