<?php
class Layout
{
	private $name = "default";
	private $variables = array();
	
	public function set($name)
	{
		return $this->name = $name;
	}
	
	public function setAttr($attr,$val)
	{
		return $this->variables[$attr] = $val;
	}
	
	public function getAttr($attr)
	{
		return $this->variables[$attr];
	}
	
	public function render()
	{
		$file = "../layouts/{$this->name}.phtml";
		if (file_exists($file))
		{
			ob_start();
			extract($this->variables);
			
			require($file);
			
			$content = ob_get_clean();
			foreach ($this->variables as $k => $v) { $content = str_replace("%".$k."%",$v,$content); }
			return $content;
		}
		else { throw new Exception("Layout {$this->name} not found."); }
	}
}
