<?php
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
		$this->file = "../views/{$this->controller}/{$this->action}.phtml";
	}

	static function exists($controller, $action)
	{
		return file_exists("../views/{$controller}/{$action}.phtml");
	}
	
	public function set($controller = null, $action = null)
	{
		if ($action) { $this->action = $action; }
		if ($controller) { $this->controller = $controller; }
	}
	
	public function setAttr($var,$value)
	{
		return $this->variables[$var] = $value;
	}
	
	public function getAttr($var)
	{
		return $this->variables[$var];
	}
	
	public function render()
	{
		if (self::exists($this->controller, $this->action)) 
		{
			ob_start();
			foreach ($this->variables as $k => $v) { $$k = $v; }

			require ($this->file);

			$content = ob_get_clean();
			foreach ($this->variables as $k => $v) 
			{
				if (!is_object($v)) { $content = str_replace("%".$k."%",$v,$content); }
			}
			return $content;
		}
		else { throw new Exception("View {$this->controller}/{$this->action} not found"); }	
	}
}
