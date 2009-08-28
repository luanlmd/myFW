<?php
class Link
{
	var $uri = "";
	
	function Link($uri = "")
	{
		$this->uri = $uri;
	}
	
	function __toString()
	{
		return App::$virtualRoot."/".$this->uri;
	}
}
