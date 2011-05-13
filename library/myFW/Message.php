<?php
namespace myFW;

class Message
{
	var $type;
	var $text;
	var $data;

	function __construct($type, $text = null, $data = null)
	{
		$this->type = $type;
		$this->text = $text;
		$this->data = $data;
	}

	function __toString()
	{
		return json_encode($this);
	}
}
