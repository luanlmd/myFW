<?php
namespace myFW;

class Layout extends View
{
	private $name = "index";

	public function set($name)
	{
		return $this->name = $name;
	}
	
	public function render()
	{
		$path = implode('/',$this->request->path);
		if ($path) { $path.='/'; }
		$file = $this->request->environment->documentRoot."app/layouts/{$path}{$this->name}.phtml";

		if (file_exists($file))
		{
			ob_start();
			extract($this->variables);
			
			require($file);
			
			$content = ob_get_clean();
			foreach ($this->variables as $k => $v)
			{
				if (!is_object($v) && !is_array($v)) { $content = str_replace("<!--\$".$k."-->",$v,$content); }
			}
			return $content;
		}
		throw new \Exception("Layout {$this->name} not found.",404);
	}
}
