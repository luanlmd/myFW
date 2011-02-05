<?php
namespace controllers;
class Index extends \library\ThinPHP\Controller
{
	function indexAction()
	{
		// Set a var to be used in the view file
		$this->view->cfile = __FILE__;
	}
}
