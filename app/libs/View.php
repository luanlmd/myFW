<?php
class View
{
	private $variables = array();
	public function set($methodName)
	{
		return App::$methodName = $methodName;
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
		$view = "app/views/".App::$controlName."/".App::$methodName.".phtml";
		if (file_exists($view)) 
		{
			ob_start();
			foreach ($this->variables as $k => $v) { $$k = $v; }
			try
			{
				require ($view);
			}
			catch(Exception $ex) { throw $ex; }
			$content = ob_get_clean();
			foreach ($this->variables as $k => $v) 
			{
				if (!is_object($v)) { $content = str_replace("%".$k."%",$v,$content); }
			}
			return $content;
		}
		else { throw new Exception("View ".$view." not found");	}	
	}
}
