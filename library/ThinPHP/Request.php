<?php
namespace library\ThinPHP;

class Request
{
	static private function removeInjection($tmp)
	{
		$tmp = str_ireplace("--", "", $tmp);
		$tmp = str_ireplace("'", "''", $tmp);
		return trim($tmp);
	}

	static function get($v = null)
	{
		global $_GET;
		if (!$v) { return $_GET; }
		if (!isset($_GET[$v])) { return null; }
		
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
		$uri = explode('?', $uri);
		$uri = $uri[0];
		$root = substr(App::$virtualRoot, 0, -1);
		$uri = str_replace($root,"",$uri);
		return self::removeInjection($uri);
	}

	static function par($index)
	{
		$pieces = explode("/",self::uri());
		array_shift($pieces);
		if (is_numeric($index))
		{		
			$array = null;
			foreach($pieces as $piece)
			{
				$par = explode(":",$piece);
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
			$par = explode(":",$piece);
			if ($par[0] == $index) { return $par[1]; }
		}
		return null;
	}

	public static function postToObject($type = 'DTO')
	{
		$object = new $type;

		foreach($_POST as $k => $v)
		{
			$object->$k = Request::post($k);
		}
		return $object;
	}

	public static function postIntoObject(&$object)
	{
		foreach($_POST as $k => $v)
		{
			$setter = "set{$k}";
			if (method_exists($object, $setter))
			{
				$object->$setter($v);
			}
			else if (property_exists($object, $k))
			{
				$object->$k = $v;
			}
		}
		return $object;
	}

	static function isAjax()
	{
		return isset($_SERVER["X-Requested-With"]);
	}
	static function isPost()
	{
		return ($_SERVER["REQUEST_METHOD"] == "POST");
	}
	static function isGet()
	{
		return ($_SERVER["REQUEST_METHOD"] == "GET");
	}
	static function isDelete()
	{
		return ($_SERVER["REQUEST_METHOD"] == "DELETE");
	}
	static function isPut()
	{
		return ($_SERVER["REQUEST_METHOD"] == "PUT");
	}
}
