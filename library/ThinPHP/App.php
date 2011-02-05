<?php
namespace library\ThinPHP;

class App
{
	/** Instance of the framework
	*
	* @var Application
	*/
	
	private static $instance;
	
	/** get the instance of the Sinister framework
	*
	* @return Sinister\Sinister
	*/
	public static function getInstance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

	public static $projectId;
	public static $virtualRoot;
	public static $documentRoot;
	public static $base;

	public static $environment = 'production';
	public static $salt ;

	public static $controlName;
	public static $methodName;
	
	private static $routes = array();
	
	static function addRoute($re, $c = "index", $m = "index")
	{
		self::$routes[] = array($re,$c,$m);
	}
	
	/**
	* Convert long-url to LongUrl
	* @param $str String
	* @return String
	*/
    public static function camelize($str='')
    {
        return str_replace(' ', '', ucwords(str_replace(array('_', '-'), ' ', $str)));
    }

	/**
	* Convert LongUrl to long-url
	* @param $str String
	* @return String
	*/
    public static function uncamelize($str='')
    {
        return preg_replace('@^_+|_+$@', '', strtolower(preg_replace("/([A-Z])/", "_$1", $str)));
    }
    
    public static function urlToAction($url)
    {
    	return lcfirst(self::camelize($url))."Action";
    }
       	
	static function render($controllerName, $actionName)
	{

		$viewExists = View::exists($controllerName, $actionName);
		
		$controllerClass = "\\controllers\\".self::camelize($controllerName);
		$actionMethod = self::camelize($actionName).'Action';
	
		if (class_exists($controllerClass))
		{
			$controllerInstance = new $controllerClass($controllerName, $actionName);
			if (is_callable(array($controllerInstance,$actionMethod))) $controllerInstance->$actionMethod();
			else if (!$viewExists) throw new Exception("Action {$controllerClass}/{$actionMethod} not found",404);
		}
		else if (!$viewExists) throw new Exception("Controller {$controllerClass} not found",404);
		else $controllerInstance = new Controller();
				
		return $controllerInstance->render();
	}
	
	static function run($projectId = "thinphp")
	{	
		Exception::registerHandler();

		self::$projectId = $projectId;
		self::$virtualRoot = str_replace("public/","",str_replace($_SERVER["DOCUMENT_ROOT"],"",str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"])));
		self::$documentRoot = realpath(dirname(__FILE__).'/../../').'/';

		$protocol = explode('/',$_SERVER['SERVER_PROTOCOL']);
		self::$base = strtolower(array_shift($protocol)) . '://' . $_SERVER['HTTP_HOST'] . self::$virtualRoot;

		//Remove URL's useless parts
		if (Request::par(0) == "index") { Response::redirect(Request::par(1)); }
		if (Request::par(1) == "index") { Response::redirect(Request::par(0)); }

		//Set default settings
		date_default_timezone_set("Etc/GMT");
		header("Content-Type: text/html; charset=utf-8");
		session_start();
		
		//Verify if IndexController has the method/view of the first parameter
		if (!Request::par(1) && (is_callable(array("\\controllers\\Index",self::urlToAction(Request::par(0)))) || View::exists("index", Request::par(0)) ))
		{
			self::$controlName = "index";
			self::$methodName = Request::par(0);
		}
		
		//Look for a route that match the url, if find, set the controller and method
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
		
		//Render the view and the template
		$page = '';
		try
		{
			$page = self::render(self::$controlName, self::$methodName);
		}
		catch(Exception $e)
		{
			if (self::$environment == 'test') { throw $e; }
			else
			{
				Error::log($e);
				try
				{
					if ($e->getCode() == 404) { $page = self::render('error', 'error404'); }
					else if ($e->getCode() == 403) { $page = self::render('error', 'error403'); }
					else { $page = self::render('error', 'error500'); }
				}
				catch(Exception $e)
				{
					if (self::$environment == 'test') { throw $e; }
					else
					{
						Error::log($e);
						exit("Awful Error");
					}
				}
			}
		}
		echo $page;
	}
}
