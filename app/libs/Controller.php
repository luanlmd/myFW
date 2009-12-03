<?php
class Controller
{
	var $_view = null;
	
	function __construct()
	{
		$this->_view = new View();
	}
	
	/**
	* Render the View
	*
	*/
	function render()
	{
		return $this->_view->render();
	}
	
	/**
	* Authomatic set attributes to the View
	*
	* @attr		string
	* @val		string
	* @access	public
	*/
	private function __set($attr, $val)
	{
		if ($attr == '_view') { $this->_view->set($val); }
		else if ($attr == '_template') { Template::set($val); }
		else { $this->_view->setAttr($attr, $val); }
	}
	
	/**
	* Return the Controller's or the View's attribute
	*
	* @attr		string
	* @access	public
	*/
	private function __get($attr)
	{
		if (isset($this->$attr)) { return $this->$attr; };
		return $this->_view->getAttr($attr);	
	}
}
