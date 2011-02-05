<?php
namespace library\ThinPHP;

class Message
{
	var $type;
	var $text;
	var $data;

	function Message($type, $text = null, $data = null)
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
