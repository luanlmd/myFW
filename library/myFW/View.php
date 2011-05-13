<?php
namespace myFW;

class View
{
	protected $request;
	protected $response;
	protected $variables = array();
	
	function __construct($request, $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function __get($key)
	{
		return $this->variables[$key];
	}

	public function __set($key, $value)
	{
		return $this->variables[$key] = $value;
	}
	
	public function snippet($name)
	{
		$snippet = new Snippet($this->request, $this->response,  $name, $this->variables);
		return $snippet->render();
	}
	
	public function render()
	{
		$path = implode('/',$this->request->path);
		if ($path) { $path.='/'; }
		$file = $this->request->environment->documentRoot."app/views/{$path}{$this->request->controller}/{$this->request->action}.phtml";

		if (file_exists($file))
		{
			ob_start();
			extract($this->variables);
			require ($file);

			$content = ob_get_clean();
			foreach ($this->variables as $k => $v) 
			{
				if (!is_object($v) && !is_array($v)) { $content = str_replace("<!--\$".$k."-->",$v,$content); }
			}
			return $content;
		}
		throw new \Exception("View {$this->request->controller}/{$this->request->action} not found");
	}
}
