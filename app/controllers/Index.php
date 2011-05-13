<?php
namespace app\controllers;
class Index extends Master
{
	function init()
	{
		parent::init();
		$this->example = new \stdClass();
		$this->example->cfile = __FILE__;		
	}
	
	function indexAction()
	{
		// Set a var to be used in the view file
		$this->_view->cfile = $this->example->cfile;
	}
}
