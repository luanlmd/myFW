<?php
class Controller
{
	var $_view = null;
	var $_layout = null;
	
	function __construct($controller, $action)
	{
		$this->_view = new View($controller, $action);
		$this->_layout = new Layout();
	}
	
	/**
	* Render the View
	*/
	function render()
	{
		if (Request::isAjax()) { return $this->_view->render(); }
		else
		{
			$content = $this->_view->render();
			$this->_layout->setAttr("content",$content);
			return $this->_layout->render();
		}
	}
	
	/**
	* Authomatic set attributes to the View
	*
	* @attr		string
	* @val		string
	* @access	public
	*/
	public function __set($attr, $val)
	{
		if ($attr == '_view') { $this->_view->set($val); }
		else if ($attr == '_layout') { $this->_layout->set($val); }
		else { $this->_view->setAttr($attr, $val); }
	}
	
	/**
	* Return the Controller's or the View's attribute
	*
	* @attr		string
	* @access	public
	*/
	public function __get($attr)
	{
		if (isset($this->$attr)) { return $this->$attr; };
		return $this->_view->getAttr($attr);	
	}
}
