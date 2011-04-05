<?php
namespace library\myFW;

class Dispacher
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
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
    
	public function render($path, $controller, $action)
	{
		$controller = $this->camelize($controller);
		$action = lcfirst($this->camelize($action.'-action'));
		$path = implode('\\',$path);
		if ($path) { $path.='\\'; }
		
		$controllerClass = 'controllers\\'.$path.$controller;
		
		if(class_exists($controllerClass))
		{
			$c = new $controllerClass($this->request);
			if (is_callable(array($c,'init'))) { $c->init(); }
			if (is_callable(array($c,$action))) { $c->$action(); }
			return $c->render();
		}
		else
		{
			throw new Exception('Controller '. $controllerClass .'not found.',404);
		}
	}

	public function run()
	{
		try
		{
			return $this->render($this->request->path,$this->request->controller,$this->request->action);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}
