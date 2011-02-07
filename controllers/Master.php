<?php
namespace controllers;

class Master extends \library\ThinPHP\Controller
{
	function init()
	{
		$this->_layout->base = $this->_request->environment->base;
	}
}