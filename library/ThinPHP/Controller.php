<?php
namespace library\ThinPHP;

class Controller
{
	var $view = null;
	var $layout = null;
	
	function __construct($controller, $action)
	{
		$this->view = new View($controller, $action);
		$this->layout = new Layout();
	}

	/**
	 * Render the Layout and the View
	 *
	 * @return string
	 */
	function render()
	{
		if (Request::isAjax()) { return $this->view->render(); }
		else
		{
			$this->layout->content = $this->view->render();
			if (method_exists($this, 'defaultLayout')) { $this->defaultLayout(); }
			return $this->layout->render();
		}
	}
}
