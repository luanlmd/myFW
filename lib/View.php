<?php
class View extends Object
{
	private static $variables = array();
	static function set($methodName)
	{
		return App::$methodName = $methodName;
	}
	public static function setVar($var,$value)
	{
		return self::$variables[$var] = $value;
	}
	public function getVar($var)
	{
		return self::$variables[$var];
	}
	static function render()
	{
		$view = "app/views/".App::$controlName."/".App::$methodName.".php";
		if (file_exists($view)) 
		{
			ob_start();
			foreach (self::$variables as $k => $v) { $$k = $v; }
			try {
				require ($view);
			}
			catch(Exception $ex) { throw $ex; }
			$content = ob_get_clean();
			foreach (self::$variables as $k => $v) 
			{
				if (!is_object($v)) { $content = str_replace("%".$k."%",$v,$content); }
			}
			return $content;
		}
		else { throw new Exception("View ".$view." not found");	}	
	}
}
