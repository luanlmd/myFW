<?php
class IndexController extends Controller
{
	function indexAction()
	{
		// Set a var to be used in the view file
		$this->view->cfile = __FILE__;
	}
}