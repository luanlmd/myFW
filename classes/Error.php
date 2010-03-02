<?php
class Error
{
	public static function handler($errno, $errstr, $errfile, $errline)
	{
		throw new Exception($errstr, $errno);
	}

	public static function log($e)
	{
		//throw $e;
		if (is_writeable('../logs/'))
		{
			$file = '../logs/'.date("Y-m-d H:i:s").'.log';
			file_put_contents($file, $e);
		}
	}
}