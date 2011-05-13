<?php
namespace myFW;

class Controller
{
	
	public $_request;
	public $_view;
	public $_layout;
	public $_response;
	
	function __construct(Request $request)
	{
		$this->_request = $request;
		$this->_response = new Response($request);
		$this->_view = new View($this->_request, $this->_response);
		$this->_layout = new Layout($this->_request, $this->_response);
	}

	/**
	 * Render the Layout and the View
	 *
	 * @return string
	 */
	function render()
	{
		if ($this->_request->isAjax()) { return $this->_view->render(); }
		else
		{
			$this->_layout->content = $this->_view->render();
			if (method_exists($this, 'defaultLayout')) { $this->defaultLayout(); }
			return $this->_layout->render();
		}
	}
}
