<?php
namespace library\ThinPHP;

class View
{
	private $request;
	private $variables = array();
	
	function __construct($request)
	{
		$this->request = $request;
	}

	/*static function exists($controller, $action)
	{
		return file_exists(App::$documentRoot."views/{$controller}/{$action}.phtml");
	}
	
	public function set($controller = null, $action = null)
	{
		if ($action) { $this->action = $action; }
		if ($controller) { $this->controller = $controller; }
	}*/

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
		$path = implode('/',$this->request->path);
		if ($path) { $path.='/'; }
		$file = $this->request->environment->documentRoot."views/{$path}{$this->request->controller}/{$this->request->action}.phtml";

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
		throw new \Exception("View {$this->request->controller}/{$this->request->action} not found");
	}
}
