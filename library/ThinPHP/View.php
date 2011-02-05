<?php
namespace library\ThinPHP;

class View
{
	private $action = null;
	private $controller = null;
	private $file = null;
	private $variables = array();
	
	function __construct($controller, $action)
	{
		$this->controller = $controller;
		$this->action = $action;
	}

	static function exists($controller, $action)
	{
		return file_exists(App::$documentRoot."views/{$controller}/{$action}.phtml");
	}
	
	public function set($controller = null, $action = null)
	{
		if ($action) { $this->action = $action; }
		if ($controller) { $this->controller = $controller; }
	}

	public function __get($key)
	{
		return $this->variables[$key];
	}

	public function __set($key, $value)
	{
		return $this->variables[$key] = $value;
	}
	
	public function render()
	{
		$file = App::$documentRoot."views/{$this->controller}/{$this->action}.phtml";
		if (file_exists($file))
		{
			ob_start();
			extract($this->variables);

			require ($file);

			$content = ob_get_clean();
			foreach ($this->variables as $k => $v) 
			{
				if (!is_object($v) && !is_array($v)) { $content = str_replace("{\$".$k."}",$v,$content); }
			}
			return $content;
		}
		else { throw new \Exception("View {$this->controller}/{$this->action} not found"); }	
	}
}
