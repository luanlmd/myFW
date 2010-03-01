<?php
class Message
{
	var $type;
	var $text;
	var $data;

	function Message($type, $text = null, $data = null)
	{
		$this->type = $type;
		$this->text = $text;
		$this->data = $package;
	}

	function __toString()
	{
		return json_encode($this);
	}
}
