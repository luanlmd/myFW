<?php
namespace library\ThinPHP;

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
	 * Render the Layout and the View
	 *
	 * @return string
	 */
	function render()
	{
		if (Request::isAjax()) { return $this->_view->render(); }
		else
		{
			$this->_layout->content = $this->_view->render();
			if (method_exists($this, 'defaultLayout')) { $this->defaultLayout(); }
			return $this->_layout->render();
		}
	}
}
