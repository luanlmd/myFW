<?php
namespace myFW;

class Snippet
{
	private $request;
	private $response;
	private $name;
	private $variables;
	
	public function __construct($request, $response, $name, $variables)
	{
		$this->request = $request;
		$this->response = $response;
		$this->name = $name;
		$this->variables = $variables;
	}
	
	public function render()
	{
		$file = $this->request->environment->documentRoot."app/snippets/{$this->name}.phtml";
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
		throw new \Exception("Snippet {$this->name} not found");
	}
}
