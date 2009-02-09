<?
class Response
{
	static function redirect($url = "", $external = false)
	{
		if ($external)
		{
			header("Location: ".$url);
			die();
		}
		header("Location: ".App::$virtualRoot.$url);
		die();
	}
}
?>
