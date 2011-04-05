<?php
namespace controllers;

class Master extends \library\myFW\Controller
{
	function init()
	{
		$this->_layout->base = $this->_request->environment->base;
	}
}
