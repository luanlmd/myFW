<?php
class DTO
{
	public function __set ($name , $value)
	{
		if (method_exists($this, $name))
		{
			$metodo = "set" . ucfirst($name);
			$this->$metodo($value);
		}
		else $this->$name = $value;
	}
	
	public function __get ($name)
	{
		if (isset($this->$name)) return $this->$name;
		if ($this->$name == NULL) return "";
		throw new Exception("Undefined Property $name");
	}
}
