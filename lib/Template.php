<?
class Template
{
	private static $template = "default";
	private static $variables = array();
	
	public static function set($template)
	{
		return self::$template = $template;
	}
	public static function setVar($var,$value)
	{
		return self::$variables[$var] = $value;
	}
	public function getVar($var)
	{
		return self::$variables[$var];
	}
	public static function render($content)
	{
		self::setVar("content",$content);
		$template = "app/templates/".self::$template."/index.php";
		if (file_exists($template))
		{
			ob_start();
			foreach (self::$variables as $k => $v) { $$k = $v; }
			require($template);
			$content = ob_get_clean();
			foreach (self::$variables as $k => $v) { $content = str_replace("%".$k."%",$v,$content); }
			return $content;
		}
		else { throw new Exception("Template ". self::$template ." not found."); }
	}
}
?>
