<?php
namespace app\controllers;

class Master extends \myFW\Controller
{
	function init()
	{
		$this->_layout->base = $this->_request->environment->base;
	}
}
