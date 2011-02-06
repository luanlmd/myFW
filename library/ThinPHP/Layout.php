<?php
namespace library\ThinPHP;

class Layout
{
	private $request;
	private $name = "index";
	private $variables = array();
	
	public function __construct($request)
	{
		$this->request = $request;
	}

	/*public function set($name)
	{
		return $this->name = $name;
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
		$file = $this->request->environment->documentRoot."layouts/{$path}{$this->name}.phtml";

		if (file_exists($file))
		{
			ob_start();
			extract($this->variables);
			
			require($file);
			
			$content = ob_get_clean();
			foreach ($this->variables as $k => $v)
			{
				if (!is_object($v) && !is_array($v)) { $content = str_replace("{\$".$k."}",$v,$content); }
			}
			return $content;
		}
		throw new \Exception("Layout {$this->name} not found.",404);
	}
}
