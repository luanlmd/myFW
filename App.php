<?php
function __autoload($class)
{
	if (class_exists($class, false)) { return; }
	
	//Find the framework path
	$fwPath = str_replace("App.php","",__FILE__);
	
	$files = array();
	$files[] = "lib/{$class}.php";
	$files[] = "app/lib/{$class}.php";
	$files[] = "app/controllers/{$class}.php";
	$files[] = "app/models/{$class}.php";
	
	//Application folder classes
	foreach ($files as $file)
	{
		if (file_exists($file))
		{
			require($file);
			return;
		}
	}

	//Framework folder classes
	foreach ($files as $file) 
	{
		if (file_exists($fwPath.$file))
		{
			require($file);
			return;
		}
	}	

	//If couldn't find the class
	throw new Exception("Class $class not found");
}

class App
{
	public static $projectId;
	public static $virtualRoot;
	
	public static $controlName;
	public static $methodName;
	
	private static $routes = array();
	
	static function setView($methodName, $controlName = "")
	{
		self::$methodName = $methodName;
		self::$controlName = $controlName;
	}
	
	static function addRoute($re, $c = "index", $m = "index")
	{
		self::$routes[] = array($re,$c,$m);
	}
	
	function run($projectId = "thinphp")
	{
		self::$projectId = $projectId;
		self::$virtualRoot = str_replace($_SERVER["DOCUMENT_ROOT"],"",str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));

		if (Request::par(0) == "index") { Response::redirect("/"); } 
		
		date_default_timezone_set("Etc/GMT");
		header("Content-Type: text/html; charset=utf-8");
		session_start();
		
		//Verify if IndexController has the method/view of the first parameter
		if (!Request::par(1) && method_exists("IndexController",Util::urlToMethod(Request::par(0))))
		{
			self::$controlName = "index";
			self::$methodName = Request::par(0);
		}
		
		//Look for a route that match the url, if find, set the controllar and method
		foreach (self::$routes as $r)
		{
			if (ereg($r[0], Request::uri(), $match))
			{
				self::$controlName = $r[1];
				self::$methodName = $r[2];
				break;
			}
		}
		
		//If theres no controller and method already seted, use the url to set them
		if (!self::$controlName) { self::$controlName = (Request::par(0))? Request::par(0) : "index"; }
		if (!self::$methodName)	{ self::$methodName = (Request::par(1))? Request::par(1) : "index";	}
		
		//Standartize names
		$control = Util::urlToClass(self::$controlName);
		$method = Util::urlToMethod(self::$methodName);

		//Instance the controller and call the method		
		$control = new $control;
		$control->$method();
		
		//Render the view and the template
		if (Request::isAjax()) { echo View::render(); }
		else { echo Template::render(View::render()); }
	}
}
