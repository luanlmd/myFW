<?php
namespace myFW;

class Request
{
	public $environment;
	
	public $path;
	public $controller;
	public $action;
	
	public $parNum = array();
	public $parStr = array();
		
	function __construct(Environment $environment)
	{
		$this->environment = $environment;
	}
	
	private function parseUri()
	{
		$parts = explode('/', $this->environment->uri);
		foreach ($parts as $p)
		{
			if(strpos($p,':'))
			{
				$p = explode(':',$p);
				$this->parStr[$p[0]] = $p[1];
			}
			else if (trim($p))
			{
				$this->parNum[] = $p;
			}					
		}
		
		foreach (App::$routes as $r)
		{
			if (preg_match($r[0],$this->environment->uri))
			{
				$this->controller = $r[1];
				$this->action = $r[2];
				$this->path = explode('/',$r[3]);
				
				return;
			}
		}
			
		$path = array();
		foreach($this->parNum as $p)
		{
			$path[] = $p;
			if (!$this->hasPath(join('/',$path)))
			{
				unset($path[count($path)-1]);
				break;
			}
		}

		$this->parNum = array_slice($this->parNum, count($path));

		$this->path = $path;

		$this->action = end($this->parNum);
		$this->controller = prev($this->parNum);

		if (count($this->parNum) === 1)
		{
			$this->action = 'index';
			$this->controller = $this->parNum[count($this->parNum) - 1];
		}

		if (!$this->action) { $this->action = 'index'; }
		if (!$this->controller) { $this->controller = 'index'; }
	}
	
	public function isAjax()
	{
		return isset($_SERVER["X-Requested-With"]);
	}
	public function isPost()
	{
		return ($_SERVER["REQUEST_METHOD"] == "POST");
	}
	public function isGet()
	{
		return ($_SERVER["REQUEST_METHOD"] == "GET");
	}
	public function isDelete()
	{
		return ($_SERVER["REQUEST_METHOD"] == "DELETE");
	}
	public function isPut()
	{
		return ($_SERVER["REQUEST_METHOD"] == "PUT");
	}
	
	public function par($key)
	{
		if (is_number($key))
		{
			return (isset($this->parNum[$key]))? $this->parNum[$key] : null;
		}
		else
		{
			return (isset($this->parStr[$key]))? $this->parStr[$key] : null;
		}
	}
	
	private function hasPath($path)
	{
		return file_exists($this->environment->documentRoot . 'app/controllers/'.$path);
	}
	
	public function postIntoObject($object)
	{
		$props = get_object_vars($object);
		foreach ($_POST as $k => $v)
		{
			$method = 'set'.ucfirst($k);
			if (method_exists($object,$method))
			{
				$object->$method($v);
			}
			else if (array_key_exists($k,$props))
			{
				$object->$k = $v;
			}
		}
		return $object;
	}
	
	function run()
	{
		$this->parseUri();
		$dispacher = new Dispacher($this);
		return $dispacher->run();
	}
}
