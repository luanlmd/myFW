<?php
namespace myFW;

class Response
{

	private $request;
	
	function __construct($request)
	{
		$this->request = $request;
	}
	
	function redirect($uri = '')
	{
		if (preg_match('@^http@',$uri))
		{
			header('Location: '. $uri);
			die();
		}
		header('Location: '.$this->request->environment->base.$uri);
		die();
	}

	function redirectBack()
	{
		header('Location: '. $_SERVER['HTTP_REFERER']);
		die();
	}
	
	function error($message, $data = false)
	{
		Session::set('_message', new Message(-1, $message, $data));
	}
	
	function success($message, $redirect = false)
	{
		Session::set('_message', new Message(1, $message));
		if ($redirect) { $this->redirect($redirect); }
	}
	
	function warning($message, $data = false)
	{
		Session::set('_message', new Message(0, $message, $data));
	}
	
	function setHeader($key, $value)
	{
		header($key . ': ' . $value);
	}

	function getMessage()
	{
		return Session::getAndDel('_message');
	}
}
