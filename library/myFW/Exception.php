<?php
namespace library\myFW;

class Exception extends \Exception
{
	public static function registerHandler()
    {
        set_error_handler(array(new self(), 'handler'), -1);
    }
    
	public static function handler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:


			break;
		case E_WARNING:
		case E_USER_WARNING:


			break;
		case E_ERROR:
		case E_USER_ERROR:
			throw new Exception($errstr, $errno);
			break;
		default:


			break;
		}
		return true;
	}

	public static function log($e)
	{
		if (is_writeable('../logs/'))
		{
			$file = '../logs/'.date("Y-m-d H:i:s").'.log';
			file_put_contents($file, $e);
		}
	}
}
